console.log("products.js loaded ✅");

function escapeHtml(s){
  return String(s ?? "")
    .replaceAll("&","&amp;")
    .replaceAll("<","&lt;")
    .replaceAll(">","&gt;")
    .replaceAll('"',"&quot;")
    .replaceAll("'","&#039;");
}

async function loadProducts() {
  const box = document.getElementById("result");
  if (!box) return;

  box.innerHTML = "Loading...";

  const qEl = document.getElementById("q");
  const catEl = document.getElementById("category_id");
  const minEl = document.getElementById("min");
  const maxEl = document.getElementById("max");

  const q = qEl ? qEl.value.trim() : "";
  const category_id = catEl ? catEl.value : "0";
  const min = minEl ? minEl.value : "";
  const max = maxEl ? maxEl.value : "";

  const params = new URLSearchParams({ q, category_id, min, max });

  const res = await fetch("/artisanal-tea/public/api/products?" + params.toString());
  const json = await res.json();

  if (!json.ok) {
    box.innerHTML = "<p>Failed to load products.</p>";
    return;
  }

  if (!json.data || json.data.length === 0) {
    box.innerHTML = "<p>No products found.</p>";
    return;
  }

  box.innerHTML = json.data.map(p => `
    <div class="card" style="margin-bottom:10px;">
      <b>${escapeHtml(p.title)}</b>
      <div>Category: ${escapeHtml(p.category || "-")} | Type: ${escapeHtml(p.tea_type || "-")} | Origin: ${escapeHtml(p.origin || "-")}</div>
      <div>Seller: ${escapeHtml(p.seller_name)} | Stock: ${p.stock}</div>
      <div><b>৳${p.price}</b></div>
    </div>
  `).join("");
}

document.addEventListener("DOMContentLoaded", () => {
  loadProducts();

  const btn = document.getElementById("btnSearch");
  if (btn) btn.addEventListener("click", loadProducts);

  ["q","category_id","min","max"].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener("input", () => {
      clearTimeout(window.__t);
      window.__t = setTimeout(loadProducts, 250);
    });
  });
});
