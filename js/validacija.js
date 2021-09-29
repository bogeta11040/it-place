var neto = document.getElementById("neto");
var bruto = document.getElementById("bruto");

neto.addEventListener("input", function(e){

  this.setCustomValidity("");

  if(this.validity.rangeOverflow){
    this.setCustomValidity("Napačen vnos!");
  } else if(this.validity.rangeUnderflow){
    this.setCustomValidity("Napačen vnos!");
  }
});

bruto.addEventListener("input", function(e){

  this.setCustomValidity("");

  if(this.validity.rangeOverflow){
    this.setCustomValidity("Napačen vnos!");
  } else if(this.validity.rangeUnderflow){
    this.setCustomValidity("Napačen vnos!");
  }
});

document.getElementById("forma").addEventListener("submit", function(event){
	if (neto.value >= bruto.value) {
  event.preventDefault()
	alert("Napačen vnos!");
}
});
