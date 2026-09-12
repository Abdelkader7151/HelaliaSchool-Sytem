// Liberty — shared autocomplete widget for picking a student/employee/etc.
// Turns a text input + hidden id field + dropdown box into a live-filtered picker.
window.LIBERTY = window.LIBERTY || {};
window.LIBERTY.autocomplete = function (opts) {
  // opts: { inputId, hiddenId, boxId, items: () => [{id,label,sub}], onPick? }
  const input = document.getElementById(opts.inputId);
  const hidden = document.getElementById(opts.hiddenId);
  const box = document.getElementById(opts.boxId);
  if (!input || !hidden || !box) return;

  function renderList(q) {
    const list = opts.items().filter(it => !q || `${it.label} ${it.sub || ''}`.toLowerCase().includes(q.toLowerCase())).slice(0, 30);
    box.innerHTML = list.length ? list.map(it => `
      <div class="ac-item" data-id="${it.id}" style="padding:8px 12px;cursor:pointer;">
        <div style="font-weight:600;font-size:13.5px;">${it.label}</div>
        ${it.sub ? `<div class="muted small">${it.sub}</div>` : ''}
      </div>`).join('') : '<div class="muted small" style="padding:10px 12px;">No matches</div>';
    box.style.display = 'block';
    box.querySelectorAll('.ac-item').forEach(el => {
      el.addEventListener('mouseenter', () => el.style.background = 'var(--line-2)');
      el.addEventListener('mouseleave', () => el.style.background = '');
      el.addEventListener('mousedown', () => {
        const item = list.find(x => String(x.id) === el.dataset.id);
        if (!item) return;
        hidden.value = item.id;
        input.value = item.label;
        box.style.display = 'none';
        if (opts.onPick) opts.onPick(item.id);
      });
    });
  }
  input.addEventListener('input', () => { hidden.value = ''; renderList(input.value.trim()); });
  input.addEventListener('focus', () => renderList(input.value.trim()));
  document.addEventListener('click', (e) => {
    if (!e.target.closest('#' + opts.inputId) && !e.target.closest('#' + opts.boxId)) box.style.display = 'none';
  });

  // preselect: call this after setting hidden.value to sync the visible label
  return {
    setValue: (id) => {
      const item = opts.items().find(x => String(x.id) === String(id));
      hidden.value = id || '';
      input.value = item ? item.label : '';
    },
    refresh: () => renderList(input.value.trim())
  };
};

// Standard markup+CSS for an autocomplete field (call once per field container).
// container: element to fill. Returns {inputId, hiddenId, boxId}.
window.LIBERTY.autocompleteField = function (container, idBase, placeholder) {
  const inputId = idBase + '-search', hiddenId = idBase, boxId = idBase + '-ac';
  container.style.position = 'relative';
  container.innerHTML = `
    <input type="hidden" id="${hiddenId}">
    <input type="text" class="form-control" id="${inputId}" placeholder="${placeholder || 'Type to search…'}" autocomplete="off">
    <div id="${boxId}" style="position:absolute;z-index:20;top:100%;left:0;right:0;background:#fff;border:1px solid var(--line);border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.12);max-height:220px;overflow-y:auto;display:none;margin-top:4px;"></div>`;
  return { inputId, hiddenId, boxId };
};
