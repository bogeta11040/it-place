var dataList = document.getElementById('naziv');
var request = new XMLHttpRequest();


request.onreadystatechange = function(response) {
	if (request.readyState === 4) {
		if (request.status === 200) {
			var jsonOptions = JSON.parse(request.responseText);

			jsonOptions.forEach(function(item) {
				var option = document.createElement('option');
				option.value = item.kompanija;
				option.text = item.kompanija;
				dataList.appendChild(option);
				dataList.classList.add("select2");
				$(".select2").select2();
			});

		} else {
			console.log("Error.");
		}
	}
};

request.open('GET', 'kompanije.json', true);
request.send();
