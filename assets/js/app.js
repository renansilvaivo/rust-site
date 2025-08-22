
document.addEventListener('click', (e) => {
  const buyBtn = e.target.closest('[data-buy]');
  if (buyBtn) {
    const id = buyBtn.dataset.buy;
    const method = document.querySelector('input[name=payment_method]:checked')?.value || 'pix';
    fetch('/api/purchase.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({ product_id: parseInt(id), payment_method: method })
    }).then(r=>r.json()).then(data=>{
      if(data.ok){
        alert('Pedido criado! Status: ' + data.purchase.status + '\n' + (data.instructions||''));
        location.href = '/public/dashboard.php';
      } else {
        alert('Erro: ' + data.error);
      }
    });
  }
});
