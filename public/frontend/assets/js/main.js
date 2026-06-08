/* ===================================================
   Yasin Jokhadar - Personal Portfolio
   JavaScript: Theme Toggle, Scroll Animations, etc.
   =================================================== */

// ===========================
// Page Loader — إخفاء اللورد عند اكتمال التحميل
// ===========================
function initPageLoader() {
  const loader = document.getElementById('pageLoader');
  if (!loader) return;
  function hideLoader() {
    loader.classList.add('hide');
    setTimeout(() => loader.remove(), 550);
  }
  if (document.readyState === 'complete') {
    setTimeout(hideLoader, 300);
  } else {
    window.addEventListener('load', () => setTimeout(hideLoader, 300));
  }
}
initPageLoader();

document.addEventListener('DOMContentLoaded', () => {

  // ===========================
  // 1. Theme Toggle (Dark/Light)
  // ===========================
  const themeToggles = document.querySelectorAll('#themeToggle, #themeToggleMobile');
  const htmlEl = document.documentElement;

  const savedTheme = localStorage.getItem('yj-theme') || 'light';
  htmlEl.setAttribute('data-theme', savedTheme);

  themeToggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      const current = htmlEl.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      htmlEl.setAttribute('data-theme', next);
      localStorage.setItem('yj-theme', next);
    });
  });

  // ===========================
  // 2. Header scroll effect
  // ===========================
  const siteHeader = document.getElementById('siteHeader');
  const handleHeaderScroll = () => {
    if (window.scrollY > 24) {
      siteHeader?.classList.add('is-scrolled');
    } else {
      siteHeader?.classList.remove('is-scrolled');
    }
  };
  handleHeaderScroll();
  window.addEventListener('scroll', handleHeaderScroll, { passive: true });

  const navCollapse = document.getElementById('navbarNav');
  const navbarToggler = document.querySelector('.navbar-toggler');
  navCollapse?.addEventListener('show.bs.collapse', () => navbarToggler?.classList.add('is-open'));
  navCollapse?.addEventListener('hide.bs.collapse', () => navbarToggler?.classList.remove('is-open'));

  // ===========================
  // 3. Active nav link highlight
  // ===========================
  const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
  document.querySelectorAll('.main-navbar .nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#')) return;

    try {
      const linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
      if (linkPath === currentPath) {
        link.classList.add('active');
      }
    } catch (e) {
      // ignore invalid URLs
    }
  });

  // ===========================
  // 4. Scroll Animations (AOS substitute)
  // ===========================
  const animatedElements = document.querySelectorAll('.animate-on-scroll');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.01,
    rootMargin: '0px 0px -20px 0px'
  });

  animatedElements.forEach(el => observer.observe(el));

  // ===========================
  // 5. Counter Animation
  // ===========================
  const counters = document.querySelectorAll('.counter-num');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = parseInt(entry.target.getAttribute('data-count'));
        animateCounter(entry.target, target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(counter => counterObserver.observe(counter));

  function animateCounter(el, target) {
    let count = 0;
    const increment = Math.ceil(target / 60);
    const timer = setInterval(() => {
      count += increment;
      if (count >= target) {
        count = target;
        clearInterval(timer);
      }
      el.textContent = count + '+';
    }, 30);
  }

  // ===========================
  // 6. Back To Top
  // ===========================
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      backToTop?.classList.add('active');
    } else {
      backToTop?.classList.remove('active');
    }
  });

  backToTop?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // ===========================
  // 7. Lightbox for Gallery
  // ===========================
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxClose = document.getElementById('lightboxClose');

  document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', () => {
      const img = item.querySelector('img');
      if (img && lightboxImg && lightbox) {
        lightboxImg.src = img.src;
        lightboxImg.alt = img.alt;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    });
  });

  function closeLightbox() {
    lightbox?.classList.remove('active');
    document.body.style.overflow = '';
  }

  lightboxClose?.addEventListener('click', closeLightbox);
  lightbox?.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
  });

  // ===========================
  // 8. Course / Projects Filter
  // ===========================
  const filterBtns = document.querySelectorAll('.courses-filter .filter-btn, .projects-filter .filter-btn');
  const courseCards = document.querySelectorAll('.course-filter-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');
      courseCards.forEach(card => {
        if (filter === 'all' || card.getAttribute('data-category') === filter) {
          card.style.display = '';
          setTimeout(() => card.style.opacity = '1', 10);
        } else {
          card.style.opacity = '0';
          setTimeout(() => card.style.display = 'none', 300);
        }
      });
    });
  });

  // ===========================
  // 8b. Blog Filter + Search
  // ===========================
  const blogFilterBar = document.querySelector('.blog-filter-bar');
  if (blogFilterBar) {
    const blogPills = blogFilterBar.querySelectorAll('.blog-filter-pill');
    const blogSearch = document.getElementById('blogSearch');
    const blogSearchClear = document.getElementById('blogSearchClear');
    const blogFilterStatus = document.getElementById('blogFilterStatus');
    const blogFilterEmpty = document.getElementById('blogFilterEmpty');
    const blogFilterReset = document.getElementById('blogFilterReset');
    const blogPostsGrid = document.getElementById('blogPostsGrid');
    const blogFeatured = document.getElementById('blogFeatured');
    const blogItems = document.querySelectorAll('.blog-filter-item');
    const categoriesWrap = blogFilterBar.querySelector('.blog-filter-categories-wrap');
    const categoriesEl = document.getElementById('blogFilterCategories');
    let activeCategory = 'all';

    const updateScrollFade = () => {
      if (!categoriesWrap || !categoriesEl) return;
      const scrollable = categoriesEl.scrollWidth > categoriesEl.clientWidth + 4;
      categoriesWrap.classList.toggle('is-scrollable', scrollable);
    };

    const normalize = (value) => (value || '').toString().toLowerCase().trim();

    const matchesItem = (item, category, query) => {
      const itemCategory = item.getAttribute('data-category') || 'all';
      const itemSearch = normalize(item.getAttribute('data-search'));
      const categoryMatch = category === 'all' || itemCategory === category;
      const searchMatch = !query || itemSearch.includes(query);
      return categoryMatch && searchMatch;
    };

    const applyBlogFilter = () => {
      const query = normalize(blogSearch?.value);
      let visibleCount = 0;

      blogItems.forEach(item => {
        const show = matchesItem(item, activeCategory, query);
        item.style.display = show ? '' : 'none';
        item.style.opacity = show ? '1' : '0';
        if (show) visibleCount++;
      });

      if (blogFeatured) {
        const showFeatured = matchesItem(blogFeatured, activeCategory, query);
        blogFeatured.style.display = showFeatured ? '' : 'none';
      }

      if (blogSearchClear) {
        blogSearchClear.hidden = !query;
      }

      if (blogFilterStatus) {
        const isFiltered = activeCategory !== 'all' || !!query;
        blogFilterStatus.classList.toggle('is-active', isFiltered);
        if (isFiltered) {
          blogFilterStatus.textContent = visibleCount
            ? `عرض ${visibleCount} ${visibleCount === 1 ? 'مقال' : 'مقالات'}`
            : 'لا توجد نتائج مطابقة';
        } else {
          blogFilterStatus.textContent = '';
        }
      }

      if (blogFilterEmpty && blogPostsGrid) {
        const showEmpty = visibleCount === 0;
        blogFilterEmpty.hidden = !showEmpty;
        blogPostsGrid.style.display = showEmpty ? 'none' : '';
      }
    };

    blogPills.forEach(pill => {
      pill.addEventListener('click', () => {
        blogPills.forEach(p => {
          p.classList.remove('active');
          p.setAttribute('aria-selected', 'false');
        });
        pill.classList.add('active');
        pill.setAttribute('aria-selected', 'true');
        activeCategory = pill.getAttribute('data-filter') || 'all';
        applyBlogFilter();
      });
    });

    blogSearch?.addEventListener('input', applyBlogFilter);

    blogSearchClear?.addEventListener('click', () => {
      if (blogSearch) {
        blogSearch.value = '';
        blogSearch.focus();
      }
      applyBlogFilter();
    });

    blogFilterReset?.addEventListener('click', () => {
      activeCategory = 'all';
      blogPills.forEach(p => {
        const isAll = p.getAttribute('data-filter') === 'all';
        p.classList.toggle('active', isAll);
        p.setAttribute('aria-selected', isAll ? 'true' : 'false');
      });
      if (blogSearch) blogSearch.value = '';
      applyBlogFilter();
    });

    updateScrollFade();
    window.addEventListener('resize', updateScrollFade);
    applyBlogFilter();
  }

  // ===========================
  // 9. Contact Form (Formspree)
  // ===========================
  const contactForm = document.getElementById('contactForm');
  contactForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = contactForm.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';

    try {
      const res = await fetch(contactForm.action, {
        method: 'POST',
        body: new FormData(contactForm),
        headers: { Accept: 'application/json' }
      });
      const data = await res.json();
      if (data.ok) {
        btn.innerHTML = '<i class="fas fa-check-circle"></i> تم الإرسال بنجاح!';
        btn.style.background = '#28a745';
        contactForm.reset();
        setTimeout(() => {
          btn.innerHTML = originalText;
          btn.disabled = false;
          btn.style.background = '';
        }, 3000);
      } else {
        btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> حدث خطأ، حاول لاحقاً';
        btn.style.background = '#dc3545';
        setTimeout(() => {
          btn.innerHTML = originalText;
          btn.disabled = false;
          btn.style.background = '';
        }, 3000);
      }
    } catch (err) {
      btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> خطأ في الاتصال';
      btn.style.background = '#dc3545';
      setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        btn.style.background = '';
      }, 3000);
    }
  });

  // ===========================
  // 10. Smooth scroll for anchor links
  // ===========================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
        // Close mobile navbar
        const navCollapse = document.querySelector('.navbar-collapse');
        if (navCollapse?.classList.contains('show')) {
          const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
          bsCollapse?.hide();
        }
      }
    });
  });

  // ===========================
  // 11. Code blocks: copy button
  // ===========================
  const article = document.querySelector('.bd-article');
  if (article) {
    const codeBlocks = article.querySelectorAll('pre code');
    codeBlocks.forEach((codeEl) => {
      const pre = codeEl.parentElement;
      if (!pre) return;

      // Wrap in container if not already wrapped
      if (!pre.parentElement.classList.contains('bd-code-block')) {
        const wrapper = document.createElement('div');
        wrapper.className = 'bd-code-block';
        pre.parentElement.insertBefore(wrapper, pre);
        wrapper.appendChild(pre);
      }

      const wrapper = pre.parentElement;

      // Avoid adding duplicate buttons
      if (wrapper.querySelector('.bd-code-copy-btn')) return;

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'bd-code-copy-btn';
      btn.innerHTML = '<i class="fas fa-copy"></i><span>نسخ</span>';

      btn.addEventListener('click', async () => {
        const codeText = codeEl.innerText || codeEl.textContent || '';
        try {
          if (navigator.clipboard && navigator.clipboard.writeText) {
            await navigator.clipboard.writeText(codeText);
          } else {
            const textarea = document.createElement('textarea');
            textarea.value = codeText;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            textarea.remove();
          }
          btn.classList.add('copied');
          const span = btn.querySelector('span');
          if (span) span.textContent = 'تم النسخ';
          setTimeout(() => {
            btn.classList.remove('copied');
            if (span) span.textContent = 'نسخ';
          }, 2000);
        } catch (err) {
          console.error('Copy failed', err);
        }
      });

      wrapper.appendChild(btn);
    });
  }

  // ===========================
  // 11. Typing effect for hero
  // ===========================
  const typingEl = document.getElementById('typingText');
  if (typingEl) {
    const texts = typingEl.getAttribute('data-texts')?.split('|') || [];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typingSpeed = 100;

    function type() {
      const currentText = texts[textIndex];
      if (!currentText) return;

      if (isDeleting) {
        typingEl.textContent = currentText.substring(0, charIndex - 1);
        charIndex--;
        typingSpeed = 50;
      } else {
        typingEl.textContent = currentText.substring(0, charIndex + 1);
        charIndex++;
        typingSpeed = 100;
      }

      if (!isDeleting && charIndex === currentText.length) {
        typingSpeed = 2000;
        isDeleting = true;
      } else if (isDeleting && charIndex === 0) {
        isDeleting = false;
        textIndex = (textIndex + 1) % texts.length;
        typingSpeed = 500;
      }

      setTimeout(type, typingSpeed);
    }

    type();
  }

});
