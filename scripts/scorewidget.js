function activate_scoreWidgets() {
	$('div[name="scoreWidget"]').each(attach_scoreWidget);
}

function attach_scoreWidget(index) {
	var down_img = $(this).find('img').first();
	var up_img = down_img.next('img');
	down_img.click(down_click);
	up_img.click(up_click);
}

function down_click(evt) {
	var scoreBox = $(evt.target).siblings(':text');
	var previousVal = parseInt(scoreBox.val());
	if (previousVal > 0) {
		scoreBox.val(previousVal - 1);
	}
}

function up_click(evt) {
	var scoreBox = $(evt.target).siblings(':text');
	var previousVal = parseInt(scoreBox.val());
	if (previousVal < 9999) {
		scoreBox.val(previousVal + 1);
	}
}

$(document).ready(activate_scoreWidgets);