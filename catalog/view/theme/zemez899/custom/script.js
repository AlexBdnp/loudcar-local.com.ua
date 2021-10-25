//окошко скидки
function modalDiscountWindow_Appeare() {
	var width = $(window).width();
	var height = $(window).height();
	var overlay = $('.ajax-overlay');	
	overlay.after('<div id="discount-window"></div>');
	let discountWindow = $('#discount-window');
	overlay.addClass('visible');
	discountWindow.css('width', '80%');
	discountWindow.css('height', '65%');
	discountWindow.css('overflow-y', 'scroll');
	discountWindow.css('position', 'fixed');
	discountWindow.css('top', '15%');
	discountWindow.css('left', '10%');
	discountWindow.css('visibility', 'visible');
	discountWindow.css('z-index', '1000');
	discountWindow.css('background-color', 'white');
	discountWindow.css('padding', '10px');
	discountWindow.css('text-align', 'center');
	discountWindow.append('<h3>Скидочный купон</h3><p><b style="color: red; ">Ваш купон: 2377</b></p><p>1) Добавьте товары в корзину<br>2) Перейдите в корзину,введите номер купона, нажмите "Применить купон"<br> 3) Нажмите "Оформить заказ" и введите ваш телефон, мы с вами обязательно свяжемся!</p><p>...или просто наберите нас:<br><a href="tel:0961956820">(096)195-68-20</a><br><a href="tel:0668699377">(066)869-93-77</a></p><p style="color: grey">Купон даёт 5% скидку от суммы всего заказа. Действителен до 4.10.2020 включительно</p>');
	overlay.on('click', modalDiscountWindow_Close );
}

function modalDiscountWindow_Close() {
	var overlay = $('.ajax-overlay');
	overlay.removeClass('visible');
	$('body').removeClass('ajax-overlay-open');
	overlay.unbind('click', modalDiscountWindow_Close );
	$('#discount-window').remove();
}

//кнопка скидки
function addDiscountButton() {
	$(document).ready(function(){
		$('.ajax-overlay').before('<div id="discountButton" class="d-sm-none d-md-block" style="position: fixed; bottom: 0; right: 0; background-color: rgb(29, 192, 16); padding: 12px; z-index: 2; width: 40%;  max-width: 200px; text-align: center;" onclick="modalDiscountWindow_Appeare()"><span style="font-size: 1.3em; font-weight: 700; color: white; ">Скидка!</span></div>');
	});
}

$(function() {
	//addDiscountButton();
})