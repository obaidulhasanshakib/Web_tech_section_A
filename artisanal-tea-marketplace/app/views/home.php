<?php require __DIR__ . '/layouts/header.php'; ?>

<h2>Welcome to Artisanal Tea Marketplace</h2>

<div class="card" style="overflow:hidden;padding:0;">
  <div style="display:grid;grid-template-columns:1.2fr .8fr;gap:0;align-items:stretch;">
    <div style="padding:18px;">
      <h3 style="margin:0 0 8px;font-size:22px;">Premium loose-leaf tea, curated for you</h3>
      <p style="margin:0 0 10px;line-height:1.6;color:#374151;">
        We connect tea lovers with trusted sellers of handcrafted, small-batch teas.
        From floral herbal blends to bold black teas—every cup is selected with care.
      </p>

      <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px;">
        <a class="btn-link" href="/artisanal-tea/public/products" style="display:inline-block;">
          <button type="button">Browse Products</button>
        </a>

        <?php if (empty($_SESSION['user'])): ?>
          <a class="btn-link" href="/artisanal-tea/public/register" style="display:inline-block;">
            <button type="button" class="secondary">Create Account</button>
          </a>
        <?php endif; ?>
      </div>

      <div style="margin-top:12px;">
        <span class="pill">Fresh</span>
        <span class="pill">Authentic</span>
        <span class="pill">Seller Verified</span>
        <span class="pill">Secure Checkout</span>
      </div>
    </div>

    <div style="min-height:240px;background:#e7efe9;">
      <img
        src="/artisanal-tea/public/assets/img/tea-hero.jpg"
        alt="Tea"
        style="width:100%;height:100%;object-fit:cover;display:block;"
        onerror="this.style.display='none'; this.parentElement.style.display='flex'; this.parentElement.style.alignItems='center'; this.parentElement.style.justifyContent='center'; this.parentElement.innerHTML='<div style=&quot;padding:18px;color:#0d3b2e;font-weight:700;text-align:center;&quot;>Add image: public/assets/img/tea-hero.jpg</div>';"
      />
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
  <div class="card">
    <h3 style="margin:0 0 8px;font-size:18px;">About Our Tea Shop</h3>
    <p style="margin:0;line-height:1.6;color:#374151;">
      Artisanal Tea Marketplace is built for tea lovers who care about origin, freshness, and quality.
      We focus on curated teas from reliable sellers—so you can explore confidently.
    </p>
  </div>

  <div class="card">
    <h3 style="margin:0 0 8px;font-size:18px;">Why We’re the Best</h3>
    <ul style="margin:0;padding-left:18px;line-height:1.7;color:#374151;">
      <li>Verified sellers and transparent product details</li>
      <li>Real customer reviews and ratings</li>
      <li>Secure login, CSRF protection, and role-based access</li>
      <li>Fast browsing with API + clean, modern UI</li>
    </ul>
  </div>
</div>

<div class="card" style="margin-top:12px;">
  <h3 style="margin:0 0 8px;font-size:18px;">Contact Us</h3>
  <p style="margin:0;color:#374151;line-height:1.7;">
    <b>Location:</b> Dhaka, Bangladesh<br>
    <b>Email:</b> artisanaltea.bd@gmail.com<br>
    <b>Phone:</b> +880 1XXXXXXXXX
  </p>
  <p style="margin:10px 0 0;color:#6b7280;">
   
  </p>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>
