import 'bootstrap'
import $ from 'jquery'
import '@fortawesome/fontawesome-free/css/all.css'

$(function() {
	$('[data-toggle="tooltip"]').tooltip()
})

$('#scrollTop').click(() => {
	$('html, body').animate({scrollTop: 0});
});

document.getElementById('logoLink').href = './../..';
document.getElementById('startLink').href = './../..';

window.onscroll = () => {
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		$('#scrollTop').show();
	} else {
		$('#scrollTop').hide();
	}
};

$.get("./../index.php?as-json", function(result) {
	for (let i in result.versions) {
		let option = document.createElement("option");
		option.text = result.versions[i];
		document.getElementById('changeVersion').add(option);
	}
});
$('#changeVersion').change((event) => {
	window.location.href = `./../${event.currentTarget.value}`;
});