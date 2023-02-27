var Osoba = Class.create({
  initialize: function(ime, prezime, jmbg) {
    this.ime 		= ime;
    this.prezime 	= prezime;
	this.jmbg  		= jmbg;
  },
  
  osobaMetod: function() {
    alert("Navedena osoba se zove " + this.ime + " " + this.prezime);
  },
  
  jmbgMetod: function() {
    alert("Osoba zvana " + this.ime + " " + this.prezime + " ima jmbg: " + this.jmbg);
  }
});