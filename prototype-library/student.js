var Student = Class.create(Osoba, {
  initialize: function($super, ime, prezime, jmbg, indeks, prosjek) {
    this.indeks = indeks;
    this.prosjek = prosjek;
    $super(ime, prezime, jmbg);
  }
});

Student.addMethods({
  indeksMetod: function() {
    alert("Student " + this.ime + " " + this.prezime + " ima broj indeksa " + this.indeks);
  }
});

Student.addMethods({
  prosjekMetod: function() {
    alert("Student " + this.ime + " " + this.prezime + " ima prosjek ocjena " + this.prosjek);
  }
});

Student.addMethods({
  jmbgMetod: function($super) {
   $super();
        alert("Student " + this.ime + " " + this.prezime + " ima jmbg broj " + this.jmbg);
  }
});