/* ==========================================================================
   HELALIA LANGUAGE SCHOOL — site behaviour
   No libraries. Everything here is progressive: with JS off the pages are
   still complete, and prefers-reduced-motion strips the decoration out.
   ========================================================================== */
(function () {
  "use strict";

  var reduced = window.matchMedia("(prefers-reduced-motion: reduce)");
  var still = reduced.matches;
  var $  = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---------- toast (forms are preview-only on this static build) -------- */
  function toast(msg) {
    var el = $(".toast");
    if (!el) {
      el = document.createElement("div");
      el.className = "toast";
      el.setAttribute("role", "status");
      el.setAttribute("aria-live", "polite");
      document.body.appendChild(el);
    }
    el.textContent = msg;
    void el.offsetWidth;
    el.classList.add("show");
    clearTimeout(el._t);
    el._t = setTimeout(function () { el.classList.remove("show"); }, 4200);
  }

  /* ---------- the hero film ---------------------------------------------
     One video, no slideshow. If helalia-sun.mp4 is not on the server yet the
     poster frame is what shows, which is exactly what we want. Under reduced
     motion we reload the element without playing it so the poster stays. */
  function hero() {
    var v = $(".hero-video");
    if (!v) return;

    function freeze() {
      v.removeAttribute("autoplay");
      v.loop = false;
      try { v.pause(); } catch (e) {}
      try { v.load(); } catch (e) {}   /* back to the poster frame */
    }
    function thaw() {
      v.loop = true;
      var p = v.play();
      if (p && p.catch) p.catch(function () { /* browser said no; poster stands */ });
    }

    if (still) freeze(); else thaw();

    if (reduced.addEventListener) {
      reduced.addEventListener("change", function (e) {
        still = e.matches;
        if (still) freeze(); else thaw();
      });
    }

    /* stop decoding the film while it is off screen */
    if ("IntersectionObserver" in window) {
      new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (still) return;
          if (en.isIntersecting) { var p = v.play(); if (p && p.catch) p.catch(function () {}); }
          else { try { v.pause(); } catch (e) {} }
        });
      }, { threshold: 0.05 }).observe(v);
    }
  }

  /* ---------- header: glass over the film, condensed after it ------------ */
  function header() {
    var head = $("header.site");
    var hero = $(".hero");
    if (!head) return;
    var trip = hero ? Math.max(120, hero.offsetHeight * 0.72) : 40;
    var ticking = false;

    function paint() {
      var y = window.pageYOffset || document.documentElement.scrollTop;
      head.classList.toggle("is-lifted", y > trip);
      if (hero && !still) {
        var p = Math.min(1, y / Math.max(1, hero.offsetHeight));
        hero.style.setProperty("--scroll", p.toFixed(3));
      }
      ticking = false;
    }
    function onScroll() {
      if (!ticking) { ticking = true; requestAnimationFrame(paint); }
    }
    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", function () {
      trip = hero ? Math.max(120, hero.offsetHeight * 0.72) : 40;
      paint();
    }, { passive: true });
    paint();
  }

  /* ---------- mobile navigation ------------------------------------------ */
  function nav() {
    var btn = $(".menu-toggle");
    var panel = $("nav.primary");
    if (!btn || !panel) return;

    function set(open) {
      document.body.classList.toggle("nav-open", open);
      btn.setAttribute("aria-expanded", open ? "true" : "false");
      if (open) { var first = panel.querySelector("a"); if (first) first.focus(); }
    }
    btn.addEventListener("click", function () {
      set(!document.body.classList.contains("nav-open"));
    });
    panel.addEventListener("click", function (e) {
      if (e.target.closest("a")) set(false);
    });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && document.body.classList.contains("nav-open")) {
        set(false);
        btn.focus();
      }
    });
    window.addEventListener("resize", function () {
      if (window.innerWidth > 900) set(false);
    }, { passive: true });
  }

  /* ---------- scroll-linked reveals -------------------------------------- */
  function reveals() {
    var targets = $$("[data-rise], [data-draw], [data-split], .path");
    if (!targets.length) return;

    if (still || !("IntersectionObserver" in window)) {
      targets.forEach(function (el) { el.classList.add("is-in"); });
      return;
    }
    /* stagger siblings that share a parent, unless the page set --i itself */
    $$("[data-stagger]").forEach(function (group) {
      $$("[data-rise]", group).forEach(function (el, i) {
        if (!el.style.getPropertyValue("--i")) el.style.setProperty("--i", i);
      });
    });

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        en.target.classList.add("is-in");
        io.unobserve(en.target);
      });
    }, { rootMargin: "0px 0px -12% 0px", threshold: 0.12 });

    targets.forEach(function (el) { io.observe(el); });
  }

  /* ---------- display headings lift word by word ------------------------- */
  function splitWords() {
    if (still) return;
    $$("[data-split]").forEach(function (el) {
      var words = el.textContent.trim().split(/\s+/);
      var frag = document.createDocumentFragment();
      words.forEach(function (word, i) {
        var span = document.createElement("span");
        span.className = "w";
        span.style.setProperty("--wi", i);
        var inner = document.createElement("i");
        inner.textContent = word;
        span.appendChild(inner);
        frag.appendChild(span);
        if (i < words.length - 1) frag.appendChild(document.createTextNode(" "));
      });
      el.textContent = "";
      el.appendChild(frag);
    });
  }

  /* ---------- buttons warm under the pointer ----------------------------- */
  function warmth() {
    if (still) return;
    document.addEventListener("pointermove", function (e) {
      var b = e.target.closest && e.target.closest(".btn");
      if (!b) return;
      var r = b.getBoundingClientRect();
      b.style.setProperty("--mx", (e.clientX - r.left) + "px");
      b.style.setProperty("--my", (e.clientY - r.top) + "px");
    }, { passive: true });
  }

  /* ---------- page transitions: courtyard to classroom ------------------- */
  function transitions() {
    if (still) return;
    var wipe = document.createElement("div");
    wipe.className = "roomwipe";
    wipe.setAttribute("aria-hidden", "true");
    document.body.appendChild(wipe);

    document.addEventListener("click", function (e) {
      var a = e.target.closest && e.target.closest("a");
      if (!a) return;
      if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      if (a.target && a.target !== "_self") return;
      if (a.hasAttribute("download") || a.dataset.noTransition !== undefined) return;
      var href = a.getAttribute("href") || "";
      if (!href || href.charAt(0) === "#" || /^(mailto|tel|https?):/i.test(href)) {
        if (!/^https?:/i.test(href)) return;
        if (a.hostname !== window.location.hostname) return;
      }
      if (a.href === window.location.href) return;
      e.preventDefault();
      document.body.classList.add("is-leaving");
      setTimeout(function () { window.location.href = a.href; }, 440);
    });

    /* coming back through history must not land on a navy panel */
    window.addEventListener("pageshow", function () {
      document.body.classList.remove("is-leaving");
    });
  }

  /* ---------- preview-only forms ----------------------------------------- */
  function forms() {
    $$("form[data-preview]").forEach(function (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        toast("This is a preview of the redesigned site — nothing is sent. Connect the school system before going live.");
      });
    });
  }

  /* ---------- admission stepper ------------------------------------------ */
  function stepper() {
    var box = $(".stepper");
    if (!box) return;
    var tabs = $$(".step-rail button", box);
    var panels = $$(".step-panel", box);
    if (!tabs.length || !panels.length) return;

    function go(n) {
      n = Math.max(0, Math.min(panels.length - 1, n));
      tabs.forEach(function (t, i) {
        t.classList.toggle("is-on", i === n);
        t.classList.toggle("is-done", i < n);
        t.setAttribute("aria-selected", i === n ? "true" : "false");
        t.tabIndex = i === n ? 0 : -1;
      });
      panels.forEach(function (p, i) {
        p.classList.toggle("is-on", i === n);
        p.hidden = i !== n;
      });
      box.dataset.step = n;
      var top = box.getBoundingClientRect().top + window.pageYOffset - 120;
      if (window.pageYOffset > top) window.scrollTo({ top: top, behavior: still ? "auto" : "smooth" });
    }

    tabs.forEach(function (t, i) { t.addEventListener("click", function () { go(i); }); });
    $$("[data-step-next]", box).forEach(function (b) {
      b.addEventListener("click", function () { go(Number(box.dataset.step || 0) + 1); });
    });
    $$("[data-step-back]", box).forEach(function (b) {
      b.addEventListener("click", function () { go(Number(box.dataset.step || 0) - 1); });
    });
    go(0);
  }

  /* ---------- events calendar -------------------------------------------- */
  function matchEv(el, f) {
    var kind = el.dataset.kind, term = el.dataset.term;
    return f === "all" ||
      (f === "term1" && (term === "1" || term === "break")) ||
      (f === "term2" && term === "2") ||
      (f === "holiday" && kind === "holiday") ||
      (f === "exam" && kind === "exam") ||
      (f === "campus" && kind === "campus");
  }

  function calendar() {
    var box = $(".cal-box");
    if (!box) return;

    var months = $$(".cal-month", box);
    var title = $(".cal-title", box);
    var jumps = $$(".cal-jumps button", box);
    var detail = $(".cal-detail", box);
    var i = Math.max(0, months.findIndex(function (m) { return m.classList.contains("is-on"); }));

    function stagger(month) {
      $$(".day.has", month).forEach(function (d, n) { d.style.setProperty("--d", n); });
    }

    function show(n) {
      i = (n + months.length) % months.length;
      months.forEach(function (m, idx) { m.classList.toggle("is-on", idx === i); });
      jumps.forEach(function (b, idx) { b.classList.toggle("is-on", idx === i); });
      if (title) title.textContent = months[i].dataset.label;
      stagger(months[i]);
      if (detail) { detail.hidden = true; detail.innerHTML = ""; }
      $$(".day.is-open", box).forEach(function (d) { d.classList.remove("is-open"); });
    }

    var prev = $(".cal-prev", box), next = $(".cal-next", box);
    if (prev) prev.addEventListener("click", function () { show(i - 1); });
    if (next) next.addEventListener("click", function () { show(i + 1); });
    jumps.forEach(function (b) {
      b.addEventListener("click", function () { show(Number(b.dataset.jump)); });
    });
    function open(day) {
      if (!detail) return;
      $$(".day.is-open", box).forEach(function (d) { d.classList.remove("is-open"); });
      day.classList.add("is-open");
      var vis = $$(".ev", day).filter(function (ev) { return !ev.classList.contains("is-hidden"); });
      if (!vis.length) { detail.hidden = true; return; }
      var when = new Date(day.dataset.date + "T00:00:00").toLocaleDateString("en-GB", {
        weekday: "long", day: "numeric", month: "long", year: "numeric"
      });
      var html = "<strong>" + when + "</strong>";
      vis.forEach(function (ev) {
        html += "<p><b>" + ev.textContent + "</b> — " + (ev.getAttribute("title") || "") + "</p>";
      });
      detail.innerHTML = html;
      detail.hidden = false;
    }

    box.addEventListener("click", function (e) {
      var day = e.target.closest(".day.has");
      if (day) open(day);
    });
    box.addEventListener("keydown", function (e) {
      var day = e.target.closest(".day.has");
      if (!day) return;
      if (e.key === "Enter" || e.key === " ") { e.preventDefault(); open(day); }
    });

    stagger(months[i]);

    /* filters repaint which days still read as gold */
    var filters = $(".event-filters");
    if (!filters) return;
    filters.addEventListener("click", function (e) {
      var btn = e.target.closest("button[data-filter]");
      if (!btn) return;
      $$("button", filters).forEach(function (b) {
        b.classList.toggle("is-on", b === btn);
        b.setAttribute("aria-pressed", b === btn ? "true" : "false");
      });
      var f = btn.dataset.filter;
      $$(".ev").forEach(function (ev) { ev.classList.toggle("is-hidden", !matchEv(ev, f)); });
      $$(".day").forEach(function (day) {
        var any = $$(".ev", day).some(function (ev) { return !ev.classList.contains("is-hidden"); });
        day.classList.toggle("has", any);
        if (any) { day.tabIndex = 0; day.setAttribute("role", "button"); }
        else { day.removeAttribute("tabindex"); day.removeAttribute("role"); day.classList.remove("is-open"); }
      });
      if (detail) { detail.hidden = true; detail.innerHTML = ""; }
      months.forEach(stagger);
    });
  }

  /* ---------- campus sheet: infinite drift to the right ------------------- */
  function sheet() {
    var root = $(".sheet");
    if (!root || root.querySelector(".sheet-track")) return;
    var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    var kids = Array.prototype.slice.call(root.children);
    if (!kids.length) return;
    var track = document.createElement("div");
    track.className = "sheet-track";
    kids.forEach(function (n) { track.appendChild(n); });
    if (!reduce) {
      kids.forEach(function (n) {
        var clone = n.cloneNode(true);
        clone.setAttribute("aria-hidden", "true");
        clone.tabIndex = -1;
        track.appendChild(clone);
      });
      root.classList.add("is-live");
      if ("IntersectionObserver" in window) {
        var io = new IntersectionObserver(function (entries) {
          root.classList.toggle("is-offstage", !entries[0].isIntersecting);
        }, { threshold: 0 });
        io.observe(root);
      }
    }
    root.appendChild(track);
  }

  /* ---------- gallery lightbox ------------------------------------------- */
  function lightbox() {
    var links = $$("[data-zoom]");
    if (!links.length) return;
    var box = document.createElement("div");
    box.className = "lightbox";
    box.setAttribute("role", "dialog");
    box.setAttribute("aria-modal", "true");
    box.setAttribute("aria-label", "Photograph");
    box.innerHTML = '<button type="button" aria-label="Close">✕</button><img alt="">';
    document.body.appendChild(box);
    var img = $("img", box);
    var closer = $("button", box);
    var last = null;

    function close() {
      box.classList.remove("show");
      img.removeAttribute("src");
      if (last) last.focus();
    }
    links.forEach(function (a) {
      a.addEventListener("click", function (e) {
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
        e.preventDefault();
        e.stopPropagation();
        last = a;
        img.src = a.getAttribute("href");
        img.alt = a.dataset.zoom || "";
        box.classList.add("show");
        closer.focus();
      });
    });
    closer.addEventListener("click", close);
    box.addEventListener("click", function (e) { if (e.target === box) close(); });
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && box.classList.contains("show")) close();
    });
  }

  /* ---------- go ---------------------------------------------------------- */
  function boot() {
    hero();
    header();
    nav();
    splitWords();
    reveals();
    warmth();
    forms();
    stepper();
    calendar();
    sheet();
    lightbox();
    transitions();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
