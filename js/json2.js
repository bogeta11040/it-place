var rmesta = document.getElementById('rmesto');
var request2 = new XMLHttpRequest();


request2.onreadystatechange = function(response) {
	if (request2.readyState === 4) {
		if (request2.status === 200) {
			var jsonOptions = JSON.parse(request2.responseText);

			jsonOptions.forEach(function(item) {
				var option = document.createElement('option');
				option.value = item.naziv;
				option.text = item.naziv;
				rmesta.appendChild(option);
				rmesta.classList.add("select2");
				$(".select2").select2();
			});

		} else {
			console.log("Error.");
		}
	}
};

request2.open('GET', 'radnamesta.json', true);
request2.send();
