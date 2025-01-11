function ready(callback) {
  // in case the document is already rendered
  if (document.readyState != "loading") callback();
  // modern browsers
  else if (document.addEventListener)
    document.addEventListener("DOMContentLoaded", callback);
  // IE <= 8
  else
    document.attachEvent("onreadystatechange", function () {
      if (document.readyState == "complete") callback();
    });
}

ready(function () {

  // fonction js qui va permettre de traduire du html vers du texte normal 
  let articleTranslate = document.querySelectorAll('.articleTranslate');
  function translate(){
    let textBrut;
    if(articleTranslate != null){
      console.log(articleTranslate);
      for(let i=0; i<articleTranslate.length; i++){
        console.log(articleTranslate[i].innerText);
        textBrut = articleTranslate[i].innerText ;  
        articleTranslate[i].innerHTML = textBrut;  
      }
    }

  }
  translate();
});
