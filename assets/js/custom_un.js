$(document).ready(function(){


	$(function(){
		$('.cart-item-delete').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=header_cart_delete",
				data: "sepet_no_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.language-change').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=language_change",
				data: "language="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.like-post').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=like_button",
				data: "begen_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.dislike-post').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=like_button",
				data: "disbegen_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.like-dislike-post').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=like_button",
				data: "likedislike_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.dislike-like-post').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=like_button",
				data: "dislikelike_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.product-fav-go').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=favoriye_ekle",
				data: "urun_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.product-fav-del').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=favoriye_ekle",
				data: "urun_del_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.product-compare').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=compare",
				data: "urun_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.cat-grid').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "includes/func/kategori-box-gosterim.php",
				data: "grid="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.cat-grid-b').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "includes/func/kategori-box-gosterim.php",
				data: "grid_b="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.cat-list').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "includes/func/kategori-box-gosterim.php",
				data: "list="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


	$(function(){
		$('.product-compare-exit').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=compare",
				data: "cikar_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});

	$(function(){
		$('.minus-quantity').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=quantity_process",
				data: "minus_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {



					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 100);


				}
			});
			return false;
		});
	});


	$(function(){
		$('.plus-quantity').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=quantity_process",
				data: "plus_id="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {



					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 100);


				}
			});
			return false;
		});
	});

	$(function(){
		$('.currency-change').click(function(){
			var elem = $(this);
			$.ajax({
				type: "GET",
				url: "masterpiece.php?sayfa=currency_change",
				data: "kur_code="+elem.attr('data-code'),
				dataType:"json",
				success: function(data) {

					setTimeout(function(){// wait for 5 secs(2)
						location.reload(); // then reload the page.(3)
					}, 0);

				}
			});
			return false;
		});
	});


});