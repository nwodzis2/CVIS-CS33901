function openLogin(){
    var x = document.getElementById("nav-main");
      if (x.style.display === "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
  }
  document.getElementById('campus-select').addEventListener("select", useCampus, false); 
  function useCampus(){
      alert("hi");
  }
  $('select').change(function(){
    alert($(this).data('id'));
});