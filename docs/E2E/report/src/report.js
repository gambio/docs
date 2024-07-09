$(function() {
	
	let testData = testResult || [];
	let $accordion = $('#accordion');
	let iconSuccessful = '<img src="css/images/green_checkmark.png" width="16" height="16">';
	let iconFailure = '<img src="css/images/red_x.png" width="16" height="16">';
	let counter=0, firstFailure;
	
	for (const testName in testData) {
		
		let icon = testData[testName].status ? iconSuccessful : iconFailure;
		let heading = testName + "&nbsp;" + icon;
		
		if (testData[testName].status) {
			
			$accordion.append('<h3 class="successful">' + heading + '</h3>');
			
			$accordion.append('<p class="successful"><img src="' + testData[testName].baseline + '" class="img-successful"></p>');
		} else {
			
			let html = '<h3>' + heading + '</h3>'
				+ '<p class="img-failures">'
				+ '<a href="' + testData[testName].baseline + '" title="baseline"><img src="' + testData[testName].baseline + '" class="img-failure"></a>'
				+ '<a href="' + testData[testName].diff + '" title="diff"><img src="' + testData[testName].diff + '" class="img-failure"></a>'
				+ '<a href="' + testData[testName].latest + '" title="latest"><img src="' + testData[testName].latest + '" class="img-failure"></a>'
				+ '</p>';
			
			$accordion.append(html);
			
			if (firstFailure === undefined) {
				
				firstFailure = counter;
			}
		}
		
		counter++;
	}
	
	$accordion.accordion({ active: firstFailure !== undefined ? firstFailure : 0});
	$('.img-failures a').simpleLightbox({});
	
	if (firstFailure === undefined) {
		
		$('.download-notice').hide();
	}
	
	$('#hide-successful-tests').on('click', function() {
		
		$('.successful').hide();
	});
});