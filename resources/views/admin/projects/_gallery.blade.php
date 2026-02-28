<div class="card custom-card mb-4">
    <div class="card-header">
        <div class="card-title">معرض صور المشروع</div>
    </div>
    <div class="card-body">
        @if(isset($project) && $project->images->isNotEmpty())
        <div class="mb-4">
            <label class="form-label">الصور الحالية</label>
            <p class="text-muted small">يمكنك تغيير التسمية أو الترتيب. لتحديد صور للحذف استخدم "حذف".</p>
            @foreach($project->images as $i => $img)
            <div class="d-flex align-items-center gap-3 mb-3 p-2 border rounded existing-image-row">
                <img src="{{ asset('storage/' . $img->image) }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
                <input type="hidden" name="existing_images[{{ $i }}][id]" value="{{ $img->id }}">
                <div class="flex-grow-1">
                    <input type="text" name="existing_images[{{ $i }}][caption]" class="form-control form-control-sm mb-1" value="{{ $img->caption }}" placeholder="تسمية الصورة">
                    <input type="number" name="existing_images[{{ $i }}][order]" class="form-control form-control-sm" value="{{ $img->order }}" min="0" placeholder="الترتيب">
                </div>
                <div class="form-check">
                    <input class="form-check-input existing-image-delete" type="checkbox" name="existing_images[{{ $i }}][delete]" value="1" id="del_img_{{ $img->id }}">
                    <label class="form-check-label text-danger small" for="del_img_{{ $img->id }}">حذف</label>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <div>
            <label class="form-label">إضافة صور جديدة</label>
            <input type="file" name="gallery[]" class="form-control mb-2" accept="image/*" multiple>
            <p class="text-muted small mb-0">يمكنك اختيار عدة صور. التسميات الاختيارية أدناه (فارغ = بدون تسمية).</p>
            <div id="galleryCaptions" class="mt-2"></div>
        </div>
    </div>
</div>
@if(!isset($project))
<script>
document.addEventListener('DOMContentLoaded', function() {
    var inp = document.querySelector('input[name="gallery[]"]');
    if (inp) inp.addEventListener('change', function() {
        var wrap = document.getElementById('galleryCaptions');
        wrap.innerHTML = '';
        for (var i = 0; i < (this.files?.length || 0); i++) {
            var div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = '<label class="form-label small">تسمية الصورة ' + (i+1) + '</label><input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="اختياري">';
            wrap.appendChild(div);
        }
    });
});
</script>
@else
<script>
document.addEventListener('DOMContentLoaded', function() {
    var inp = document.querySelector('input[name="gallery[]"]');
    if (inp) inp.addEventListener('change', function() {
        var wrap = document.getElementById('galleryCaptions');
        wrap.innerHTML = '';
        for (var i = 0; i < (this.files?.length || 0); i++) {
            var div = document.createElement('div');
            div.className = 'mb-2';
            div.innerHTML = '<label class="form-label small">تسمية الصورة الجديدة ' + (i+1) + '</label><input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="اختياري">';
            wrap.appendChild(div);
        }
    });
});
</script>
@endif
