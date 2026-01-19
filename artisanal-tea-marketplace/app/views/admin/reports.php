<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin: Reports</h2>

<div class="card">
  <button id="btnLoad">Load Report (Ajax)</button>
  <div id="out" style="margin-top:12px;"></div>
</div>

<script>
document.getElementById('btnLoad').addEventListener('click', async () => {
  const out = document.getElementById('out');
  out.innerHTML = "Loading...";
  const res = await fetch('/artisanal-tea/public/api/admin/reports');
  const json = await res.json();
  if(!json.ok){ out.innerHTML = "Failed"; return; }

  const d = json.data;
  let html = "";
  html += `<p><b>Total Orders:</b> ${d.orders}</p>`;
  html += `<p><b>Total Revenue:</b> ৳${Number(d.revenue).toFixed(2)}</p>`;
  html += `<p><b>Top Sellers:</b></p><ul>`;
  d.top_sellers.forEach(s => {
    html += `<li>${s.seller_name} — ৳${Number(s.revenue).toFixed(2)}</li>`;
  });
  html += `</ul>`;
  out.innerHTML = html;
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
