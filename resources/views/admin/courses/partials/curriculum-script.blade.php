@section('script')
<script>
    (function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const contentRoot = document.getElementById('course-content');
        if (!contentRoot) return;

        const alertBox = document.getElementById('course-content-alert');

        function showMessage(type, message) {
            if (!alertBox) return;
            alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');
            alertBox.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
            alertBox.textContent = message;
        }

        async function sendRequest(url, method, data) {
            const options = {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: data ? JSON.stringify(data) : null,
            };

            const response = await fetch(url, options);
            if (!response.ok) {
                let msg = 'حدث خطأ غير متوقع.';
                try {
                    const json = await response.json();
                    if (json.message) {
                        msg = json.message;
                    } else if (json.errors) {
                        msg = Object.values(json.errors).flat().join(' - ');
                    }
                } catch (e) {}
                throw new Error(msg);
            }
            return response.json();
        }

        // إضافة قسم جديد
        document.getElementById('add-section-btn')?.addEventListener('click', async function () {
            const title = document.getElementById('new-section-title').value.trim();
            const order = document.getElementById('new-section-order').value;
            const isActive = document.getElementById('new-section-active').checked;
            if (!title) {
                showMessage('danger', 'يرجى إدخال عنوان القسم.');
                return;
            }
            const url = contentRoot.dataset.storeSectionUrl;
            try {
                await sendRequest(url, 'POST', {
                    title: title,
                    order: order || null,
                    is_active: isActive ? 1 : 0,
                });
                showMessage('success', 'تم إضافة القسم بنجاح.');
                location.reload();
            } catch (e) {
                showMessage('danger', e.message);
            }
        });

        // عمليات على الأقسام والدروس (edit/delete/add-lesson)
        contentRoot.addEventListener('click', async function (e) {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const action = btn.dataset.action;
            const sectionBlock = btn.closest('.section-block');

            try {
                if (action === 'delete-section') {
                    if (!confirm('هل أنت متأكد من حذف هذا القسم وجميع دروسه؟')) return;
                    await sendRequest(sectionBlock.dataset.deleteUrl, 'DELETE');
                    showMessage('success', 'تم حذف القسم بنجاح.');
                    sectionBlock.remove();
                    return;
                }

                if (action === 'edit-section') {
                    const currentTitle = sectionBlock.querySelector('strong').textContent.trim();
                    const newTitle = prompt('عنوان القسم:', currentTitle);
                    if (!newTitle) return;
                    const newOrder = prompt('ترتيب القسم (رقم):', sectionBlock.querySelector('.text-muted').textContent.replace('#','').trim());
                    const isActive = confirm('هل القسم نشط؟ (موافق = نشط / إلغاء = غير نشط)');
                    await sendRequest(sectionBlock.dataset.updateUrl, 'PUT', {
                        title: newTitle,
                        order: newOrder || 0,
                        is_active: isActive ? 1 : 0,
                    });
                    showMessage('success', 'تم تحديث القسم بنجاح.');
                    location.reload();
                    return;
                }

                if (action === 'add-lesson') {
                    const wrapper = btn.closest('.row');
                    const titleInput = wrapper.querySelector('[data-field="lesson-title"]');
                    const durationInput = wrapper.querySelector('[data-field="lesson-duration"]');
                    const orderInput = wrapper.querySelector('[data-field="lesson-order"]');
                    const previewInput = wrapper.querySelector('[data-field="lesson-preview"]');

                    const title = titleInput.value.trim();
                    if (!title) {
                        showMessage('danger', 'يرجى إدخال عنوان الدرس.');
                        return;
                    }
                    const url = sectionBlock.dataset.lessonsStoreUrl;
                    await sendRequest(url, 'POST', {
                        title: title,
                        duration_minutes: durationInput.value || null,
                        order: orderInput.value || null,
                        is_preview: previewInput.checked ? 1 : 0,
                    });
                    showMessage('success', 'تم إضافة الدرس بنجاح.');
                    location.reload();
                    return;
                }

                const lessonRow = btn.closest('.lesson-row');
                if (!lessonRow) return;

                if (action === 'delete-lesson') {
                    if (!confirm('حذف هذا الدرس؟')) return;
                    await sendRequest(lessonRow.dataset.deleteUrl, 'DELETE');
                    showMessage('success', 'تم حذف الدرس بنجاح.');
                    lessonRow.remove();
                    return;
                }

                if (action === 'edit-lesson') {
                    const currentTitle = lessonRow.children[1].textContent.trim();
                    const newTitle = prompt('عنوان الدرس:', currentTitle);
                    if (!newTitle) return;
                    const currentDuration = lessonRow.children[2].textContent.replace(' دقيقة', '').trim();
                    const newDuration = prompt('مدة الدرس (دقائق):', currentDuration || '0');
                    const isPreview = confirm('هل الدرس متاح كمعاينة؟ (موافق = نعم / إلغاء = لا)');
                    const isActive = confirm('هل الدرس نشط؟ (موافق = نشط / إلغاء = مخفي)');

                    await sendRequest(lessonRow.dataset.updateUrl, 'PUT', {
                        title: newTitle,
                        duration_minutes: newDuration || null,
                        order: parseInt(lessonRow.children[0].textContent.trim(), 10) || 0,
                        is_preview: isPreview ? 1 : 0,
                        is_active: isActive ? 1 : 0,
                    });
                    showMessage('success', 'تم تحديث الدرس بنجاح.');
                    location.reload();
                }
            } catch (err) {
                showMessage('danger', err.message);
            }
        });
    })();
</script>
@endsection

