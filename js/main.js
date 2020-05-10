$(document).ready(function(){
    korpaBrojac();
    if(window.location.href.indexOf("proizvodi.php")!=-1){
        $.ajax({
            url:"moduless/proizvodi/filterProizvodi.php",
            method:"GET",
            dataType:"json",
            success:function(res){
                ispisProizvoda(res.proizvodi,"#proizvodi",4);
                paginacija(res.brojStrana);
            },
            error:function(xhr){
                console.log(xhr);
            }
        })
        $(".filteri-Btn").click(filter);
        $("#sortDdl").change(filter);
        $(".pretragaBtn").click(filter);
        $(".activeFilters").click(function(){
            if(window.innerWidth<768){
                $(".filteri").slideToggle(); 
            }
            else{
                $(".filteri").show();
            }
        });
        $(window).resize(function(){
            if(window.innerWidth>768){
                $(".filteri").removeAttr("style");
            }
        });
    }

    else if(window.location.href.indexOf("kontakt.php")!=-1){
        $("#kontaktForma button").click(function(e){
            e.preventDefault();
            let ok=true;
            const ime=$("#kontaktIme");
            const mail=$("#kontaktMail");
            const poruka=$("#kontaktPoruka");
           
            if(!proveraIzraza(ime,imeRegex)){
                ok=false;
            }
            if(!proveraIzraza(mail,mailRegex)){
                ok=false;
            }
            if(!proveraIzraza(poruka,porukaRegex)){
                ok=false;
            }
            if(ok){
                const postObject={
                    ime:ime.val(),
                    mail:mail.val(),
                    poruka:poruka.val(),
                    dugme:"OK"
                }
                ajaxZahtev("moduless/kontakt/kontaktObrada.php",postObject,function(res){
                    $(".response").html(`<p>${res}</p>`).removeClass("text-danger").addClass("text-success");
                },function(xhr){
                    $(".response").html(`<p>${xhr.responseJSON}</p>`).addClass("text-danger");
                })
            }
        })
        //Anketa
        $("#formaAnketa").submit(function(e){
            //e.preventDefault();
            

        })
    }
    else if(window.location.href.indexOf("proizvod.php")!=-1){
        // $(".slicica:first-child").addClass("activeImage");
        // $(".slicica").click(function(e){
        //     $(".slicica").removeClass("activeImage");
        //     $(this).addClass("activeImage");
        //     galerija(e);
        // });
        $(".dodajUKorpu").on("click",dodajUKorpu);
        $("#kupiProizvod").click(dodajUKorpu);
        $("#kupiProizvod").click(function(e){
            e.preventDefault();
            window.location.href=$(this).attr("href");
        })

    }
    
    else if(window.location.href.indexOf("profil.php")!=-1){
        $(".izmena").click(function(){
            const polje=$(this).parent().find("input");
            polje.removeAttr("readonly");
            polje.removeClass("form-control-plaintext").addClass("form-control clearFocus");
            $(".dugmici").removeClass("d-none").addClass("d-block");
        })
        $(".ponisti").click(function(){
            $("#formaIzmene input").removeClass("form-control clearFocus").addClass("form-control-plaintext");
            $("#formaIzmene input").attr("readonly","readonly");
            $("#formaIzmene .greska").html("");
            $(".dugmici").removeClass("d-block").addClass("d-none");
        })
        function promenaProvera(){
            let ok=true;
            if(!proveraIzraza($("#izmenaAdresa"),adresaRegex)){
                ok=false;
            }
            if(!proveraIzraza($("#izmenaGrad"),gradRegex)){
                ok=false;
            }
            if(!proveraIzraza($("#izmenaTel"),telRegex)){
                ok=false;
            }
            if(!proveraIzraza($("#izmenaKorIme"),korImeRegex)){
                ok=false;
            }
            if(!proveraIzraza($("#izmenaMail"),mailRegex)){
                ok=false;
            }
            return ok;
        }
        function lozinkaProvera(){
            let ok=true;
            if(!proveraIzraza($("#trenutnaSifra"),lozinkaRegex)){
                ok=false;
            }
            if(proveraIzraza($("#novaSifra"),lozinkaRegex)){
                if($("#novaSifra").val()!=$("#potrvdiLozinku").val()){
                    ok=false;
                    $("#potrvdiLozinku").next().html("Molimo vas ispravno popunite ovo polje");
                }
                else{
                    $("#potrvdiLozinku").next().html("");
                }
            }
            else{
                ok=false;
            }
            return ok;
            
        }
        $("#formaIzmene").submit(function(){
            return promenaProvera();
        })
        $(".promeniSifru").click(function(e){
            e.preventDefault();
            if(lozinkaProvera()){
                let postObj={
                    trenutnaSifra:$("#trenutnaSifra").val(),
                    novaSifra:$("#novaSifra").val(),
                    potrvdiLozinku:$("#potrvdiLozinku").val(),
                    korisnik:$("#hiddenUser").val(),
                    promeniSifru:"OK"
                };
                ajaxZahtev("moduless/korisnik/promenaSifra.php",postObj,function(res){
                    $(".lozPoruka").removeClass("d-none");
                    $(".greska").html("");
                    document.querySelector("#sifraIzmena").reset();
                },
                function(xhr){
                    const res=xhr.responseJSON;
                    $(".lozPoruka").addClass("d-none");
                    res.trenutna ?  $("#trenutnaSifra").parent().find(".greska").html(res.trenutna) :  $("#trenutnaSifra").parent().find(".greska").html("");

                    res.nova ? $("#novaSifra").parent().find(".greska").html(res.nova) :  $("#novaSifra").parent().find(".greska").html("");
                
                    res.potvrda ? $("#potrvdiLozinku").parent().find(".greska").html(res.potvrda) : $("#potrvdiLozinku").parent().find(".greska").html("");
                })
            }
        })
        //Admin
    }
    else if(window.location.href.indexOf("adminPanel.php")!=-1){
        //Inbox
        $(".procitaj").click(function(){
            $(this).parent().find(".poruka").slideDown();
        })
        $(".odgovori").click(function(e){
            e.preventDefault();
            $(this).parent().find(".odgovorArea").removeClass("d-none").addClass("d-block");
            $(this).parent().find(".posalji").removeClass("d-none").addClass("d-block");
        })
        $(".zatvori").click(function(e){
            e.preventDefault();
            $(this).parent().slideUp();
            $(this).parent().find(".odgovorArea").removeClass("d-block").addClass("d-none");
            $(this).parent().find(".greska").empty();
        })
        $(".posalji").click(function(e){
            e.preventDefault();
            const odgovorArea=$(this).parent().find(".odgovorArea");
            if(proveraIzraza(odgovorArea,porukaRegex)){
                
                const odgovor={
                    odg:odgovorArea.val(),
                    posalji:true,
                    msg:$(this).data("msgid")
                }
                ajaxZahtev("moduless/administrator/porukeOdgovor.php",odgovor,function(res){
                    odgovorArea.next().html("Poruka usešno poslata.").removeClass("alert-danger").addClass("alert-success");
                    odgovorArea.attr("disabled","disabled");
                },function(xhr){
                    odgovorArea.next().html("Došlo je do greške").addClass("alert-danger");
                })
            }
        })
        //Proizvodi
        $(".adminPag").click(paginacijaPrelazAdmin);
        $("#proizvodAdmin").on("click",".obrisiBtn",function(){
            const strana=document.querySelector(".pagination .active .adminPag").dataset.strana;
            const deleteId=this.dataset.delid;
            const postObj={
                id:deleteId,
                strana:strana,
                dugme:"ok"
            }
            ajaxZahtev("moduless/administrator/adminBrisanje.php",postObj,function(res){
                ispisProizvodaAdmin(res.proizvodi);
                let html="";
                for(let i=1;i<=res.brojStrana;i++){
                 html+=`<li class="page-item"><a class="page-link adminPag" href="#" data-strana="${i}">${i}</a></li>`;
                 }
                 $(".pagination").html(html);
                 $(".page-item:last-child").addClass("active");
                 $(".page-link").click(paginacijaPrelazAdmin);
                
            },function(xhr){
                alert("Ne mozete obrisati proizvod jer se nalazi na porudzbinama!")
            })
         })
         //Navigacija
         const linkoviDdl=document.querySelector("#nazivLinka");
         $("#nazivLinka").change(function(){
            const selectedIndex=this.selectedIndex;
            const prioritet=document.querySelector("#prioritet");
            const link=this[selectedIndex].dataset.link; 
            $("#link").val(link);
            prioritet.selectedIndex=linkoviDdl[selectedIndex].dataset.order-1;
         })
         $(".promeniMeni").click(function(){
            const selectedIndex=linkoviDdl.selectedIndex;
            const link=linkoviDdl[selectedIndex].dataset.link; 
            if(proveraIzraza($("#link"),linkRegex)){
                    $("#link").parent().find(".greska").empty();
                    const postObj={
                        id:linkoviDdl.value,
                        link:$("#link").val(),
                        prioritet:$("#prioritet").val(),
                        izmena:true
                    }
                    ajaxZahtev("moduless/administrator/izmenaMeni.php",postObj,function(res){
                        $(".izmenaPoruka").html("Izmena uspela!Osvežite stranicu da vidite izmenu.").addClass("alert-success");
                    },
                    function(xhr){
                        $(".izmenaPoruka").html("Doslo je do greške").addClass("alert-danger");
                    })
            }
         })
         $(".dodajMeni").click(function(){
             let ok=true;
             if(!proveraIzraza($("#novaStavka"),nazivRegex)){
                ok=false;
             }
             if(!proveraIzraza($("#noviLink"),linkRegex)){
                ok=false;
             }
             if($("#dodajPrioritet").val()=="0"){
                ok=false;
                $("#dodajPrioritet").next().html("Molimo vas izaberite prioritet");
             }
             else{
                $("#dodajPrioritet").next().empty();
             }
             if(ok){
                const postObj={
                    naziv:$("#novaStavka").val(),
                    link:$("#noviLink").val(),
                    prioritet:$("#dodajPrioritet").val(),
                    dodavanje:true
                };
                ajaxZahtev("moduless/administrator/dodavanjeMeni.php",postObj,function(res){
                    $(".dodajPoruka").html(res).addClass("alert-success");
                },
                function(xhr){
                    const greske=xhr.responseJSON;
                    $(".dodajPoruka").html(greske.join("<br/>")).addClass("alert-danger");
                })
             }
         })
         $(".izbrisiMeni").click(function(){
             if($("#brisanjeLinka").val()!="0"){
                $("#brisanjeLinka").next().empty();
                const postObj={
                    id:$("#brisanjeLinka").val(),
                    brisanje:true
                };
                ajaxZahtev("moduless/administrator/brisanjeMeni.php",postObj,function(res){
                    $(".brisanjePoruka").html("Link uspešno obrisan!Osvežite stranicu da vidite izmenu.").addClass("alert-success");
                },
                function(){
                    $(".brisanjePoruka").html("Došlo je do greške").addClass("alert-danger");
                })
             }
             else{
                $("#brisanjeLinka").next().html("Morate izabrati barem jednu stavku za brisanje");
             }
         })
         //Korisnici
         $("#korisnici").change(function(){
             const ulogaId=this.options[this.selectedIndex].dataset.uloga;
             const ulogeDdl=document.querySelector("#uloge");
             ulogeDdl.selectedIndex=ulogaId;
         })
         $(".promeniUlogu").click(function(){
             let ok=true;
             if($("#korisnici").val()!="0"){
                $("#korisnici").next().empty();
             }
             else{
                $("#korisnici").next().html("Izaberite korisnika");
                ok=false;
             }
             if($("#uloge").val()!="0"){
                $("#uloge").next().empty();
             }
             else{
                $("#uloge").next().html("Izaberite ulogu");
                ok=false;
             }
             if(ok){
                 const postObj={
                     korisnik:$("#korisnici").val(),
                     uloga:$("#uloge").val(),
                     izmenaU:"OK"
                 }
                 ajaxZahtev("moduless/administrator/promeniUlogu.php",postObj,function(res){
                    $("#korisnici").parent().parent().find(".ulogaPoruka").html("Uloga uspeno promenjena!").removeClass("alert-danger").addClass("alert-success");
                 },
                 function(xhr){
                    $("#korisnici").parent().parent().find(".ulogaPoruka").html(xhr.responseJSON).addClass("alert-danger");
                 })
             }
         })
         $(".obrisiKor").click(function(){
            if($("#brisanjeKorDdl").val()!="0"){
               $("#brisanjeKorDdl").next().empty();
               const postObj={
                korisnik:$("#brisanjeKorDdl").val(),
                brisiU:"OK"
            }
            ajaxZahtev("moduless/administrator/brisiKorisnika.php",postObj,function(res){
               $("#brisanjeKorDdl").parent().parent().find(".ulogaPoruka").html("Korisnik uspesno obrisan").removeClass("alert-danger").addClass("alert-success");
            },
            function(xhr){
                alert("Korisnik ima porudžbine pa ga ne možete obrisati!");
            })
            }
            else{
               $("#brisanjeKorDdl").next().html("Izaberite korisnika");
               ok=false;
            }
        })
        //Anketa admin
        const pocetniGrafik={
            id:$("#ankete").val(),
            rez:"ok"
        }
        dohvatiGrafik(pocetniGrafik);
        $("#ankete").change(function(){
            const postObj={
                id:$("#ankete").val(),
                rez:"ok"
            }
            dohvatiGrafik(postObj);
        })
        $("#izmenaAnketeDdl").change(function(){
            odgovori();
        })
        $(".dodajOdg").click(function(e){
            dodajOdgInput("#dodavanjeAnkete","odg");
        })
        $(".dodajAnketu").click(function(){
            dodajAnketuProvera();
        })
        $(".aktivAnketa").click(function(e){
            e.preventDefault();
            const postObj={
                id:$("#ankete").val(),
                aktiv:true
            }
            ajaxZahtev("moduless/administrator/aktivirajAnketu.php",postObj,function(res){
                $(".aktivPoruka").removeClass("text-danger").addClass("text-success").html("Anketa aktivirana!");
            },function(xhr){
                $(".aktivPoruka").addClass("text-danger").html(xhr.responseJSON);
            })
        })
        $(".delAnketa").click(function(e){
            e.preventDefault();
            const postObj={
                id:$("#ankete").val(),
                brisi:true
            }
            ajaxZahtev("moduless/administrator/brisanjeAnkete.php",postObj,function(){
                $(".aktivPoruka").removeClass("text-danger").addClass("text-success").html("Anketa uspešno obrisana!");
            },function(xhr){
                $(".aktivPoruka").addClass("text-danger").html(xhr.responseJSON);
            })
        })
        $(".izmeniAnketuBtn").click(function(){
            izmenaOdgovora();
        })
    }
    else if(window.location.href.indexOf("proizvodIzmena.php")!=-1){
        $("#izmenaProizvodBtn").click(function(){
            const provera=proizvodProvera();
            if(provera.ok && !jQuery.isEmptyObject(provera.postObj)){
                provera.postObj.izmena="OK";
                provera.postObj.id=$("#izmenaId").val();
                ajaxZahtev("moduless/administrator/izmenaProizvoda.php",provera.postObj,function(res){
                    
                    window.location.href=`proizvod.php?id=${provera.postObj.id}`;
                },function(xhr){
                    
                    let html="";
                    for(let i of xhr.responseJSON){
                        html+=`<li>${i}</li>`;
                    }
                    $(".greskaUpdate").html(html).fadeIn();
                })
            }
        });
        $("#slikaForma").submit(function(e){
            const slikaInput=document.querySelector("#izmenaSlike");
            if(slikaInput.value!=""){
                if(slikaRegex.test(slikaInput.files[0].type)){
                    return true;
                }
                else{
                    $(this).find(".greska").html("Slika nije u dobrom foramtu!");
                    e.preventDefault();
                }
            }
            else{
                $(this).find(".greska").html("Morate izabrati sliku");
                e.preventDefault();
            }
            
           
        })
    }
    else if(window.location.href.indexOf("dodajProizvod.php")!=-1){
        $(".addDugme").click(function(){
            dodavanjeProizvoda();
        })
    }
    else{
        $.ajax({
            url:"views/najnovijiProizvodi.php",
            method:"GET",
            dataType:"json",
            success:function(res){
                ispisProizvoda(res,"#najnoviji",3);
            },
            error:function(xhr){
                console.log(xhr);
            }
        })
        
    }
    
})
let proizvodi;
var trentuniFilteri={};
//Forme regex
const adresaRegex=/^[A-ZŽČĆŠĐ][a-zšđčžć0-9]{3,29}(\s[A-z0-9]{1,19})*$/;
const gradRegex=/^[A-ZŽČĆŠĐ][a-zšđčžć]{1,14}(\s[A-ZŽČĆŠĐ][a-zšđčžć]{1,14})*$/;
const telRegex=/^06[0-59][0-9]{6,8}$/;
const korImeRegex=/^[A-z][A-z0-9\.\?\!]{3,59}$/;
const imeRegex=/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/;
const mailRegex=/^[a-z0-9\.\?]{4,}\@([a-z0-9]{3,}\.)*[a-z]{2,3}$/;
const lozinkaRegex=/^[\w\s]{6,}$/;
const porukaRegex=/^([A-zŽČĆŠĐšđčžć0-9\.\,\!\?\s]{2,})+$/;
//Proizvod regex
const nazivRegex=/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{2,59}$/;
const opisRegex=/^[A-ZŽČĆŠĐ][A-zŽČĆŠĐšđčžć0-9\,\.\/\?\!\s]{1,}$/;
const cenaRegex=/^[1-9][0-9]{0,7}$/;
const specRegex=/^[1-9][0-9]{1,3}\scm$/;
const materijalRegex=/^[A-z]{2,30}$/;
const slikaRegex=/^image\/(jpeg|jpg|png)$/;
const linkRegex=/^[A-z]{1,55}\.(html|php)$/;
//Ankete
const odgRegex=/^[A-ZŽČĆŠĐ][A-zŠĐČŽĆšđčžć0-9\s]{1,59}$/
//Function declaration
function ispisProizvoda(arr,target,brojKolona){
    const section=document.querySelector(target);
    let html="";
    if(arr.length>0){
        for(let i of arr){
            html+=`<div class="col-lg-${brojKolona} col-12 col-sm-6 p-3">
                <div class="card proizvod">
                    <a href="proizvod.php?id=${i.id}"><img src="images/${i.src}" class="card-img-top" alt="${i.alt}" /></a>
                    <div class="card-body">
                        <a href="proizvod.php?id=${i.id}"><h5 class="card-title">${i.imeProizvoda}</h5></a>
                        <span class="kategorija">${i.kategorija}</span>
                        <p class="cena">${i.cena}</p>
                        <a href="proizvod.php?id=${i.id}" class="btn dugme">Detalji</a>
                        <a href="#" class="dodajUKorpu btn" data-id="${i.id}"><i class="fa fa-cart-plus"></i></a>
                    </div>
                </div>
            </div>`;
        }
    }
    else{
        html+=`<div id="prazno">
        <h1>Nazalost nemamo prozivod koji zadovoljava date uslove</h1>
        </div>`;
    }
    section.innerHTML=html;
    $(".dodajUKorpu").on("click",dodajUKorpu);
}

function filter(e){
    e.preventDefault();
    const checkboxes=[...document.querySelectorAll("input[name=opsegCena]:checked")];
    const kategorijeCbx=[...document.querySelectorAll("input[name=kategorije]:checked")];
    const sortType=document.querySelector("#sortDdl").value;
    let kategorijeArr=[];
    let min=[];
    let max=[];
    if(checkboxes.length>0){
        min=checkboxes.map(cena=>cena.dataset.min);
        max=checkboxes.map(cena=>cena.dataset.max);
    }
    if(kategorijeCbx.length>0){
        kategorijeArr=kategorijeCbx.map(kategorija=>kategorija.value);
    }
    const postObject={
        minCena:min,
        maxCena:max,
        kategorije:kategorijeArr,
        sort:sortType,
        crit:$("#pretraga").val(),
        dugme:"OK"
    }
    trentuniFilteri=postObject;
    ajaxZahtev("moduless/proizvodi/filterProizvodi.php",postObject,function(res){
        ispisProizvoda(res.proizvodi,"#proizvodi",4);
        paginacija(res.brojStrana);
    })
}
function ajaxZahtev(url,data,success,error=function(xhr){console.log(xhr)}){
    $.ajax({
        url:url,
        method:"POST",
        dataType:"json",
        data:data,
        success:success,
        error:error
    })
}
// function galerija(e){
//     const src=e.target.getAttribute("src");
//     const alt=e.target.getAttribute("alt");
//     const velikaSlika=document.querySelector("#velikaSlika img");
//     velikaSlika.setAttribute("src",src);
//     velikaSlika.setAttribute("alt",alt);
// }
function proveraIzraza(target,regex){
    if(!regex.test(target.val().trim())){
        target.parent().find(".greska").html("Molimo vas ispravno popunite ovo polje");
        return 0;
    }
    else{
        target.parent().find(".greska").html("");
        return 1;
    }
}
function dodajUKorpu(e){
    e.preventDefault();
    const id=this.dataset.id;
    upisULS(id);
    korpaBrojac();
}
function upisULS(id){
    const korpa=JSON.parse(localStorage.getItem("korpa"));
    const noviArtikal={
        id:id,
        kolicina:1
    };
    if(korpa==null){
        const korpa=[];
        korpa.push(noviArtikal);
        const stringKorpa=JSON.stringify(korpa);
        localStorage.setItem("korpa",stringKorpa);
    }
    else{
        let find=0;
        for(let i of korpa){
            if(i.id==id){
                i.kolicina++;
                find=1;
                break;
            }
        }
        if(!find){
            korpa.push(noviArtikal);
        }
        const stringKorpa=JSON.stringify(korpa);
        localStorage.setItem("korpa",stringKorpa);
    }
}
function korpaBrojac(){
    const korpa=JSON.parse(localStorage.getItem("korpa"));
    let suma=0;
    if(korpa!=null){
        for(let i of korpa){
            suma+=i.kolicina;
        }
        document.querySelector("#korpaBrojac").innerHTML=suma;
    }
}
function paginacija(brojStranica){
    const target=document.querySelector(".pagination");
    let html="";
    for(let i=1;i<=brojStranica;i++){
        html+=`<li class="page-item"><a class="page-link" href="#" data-strana="${i}">${i}</a></li> `;
    }
    target.innerHTML=html;
    $(".page-item:first-child").addClass("active");
    $(".page-link").click(paginacijaPrelaz);
}
function paginacijaPrelaz(e){
    e.preventDefault();
        $(".page-item").removeClass("active");
        $(this).parent().addClass("active");
        const brojStrane=this.dataset.strana;
        const postObj=trentuniFilteri;
        trentuniFilteri.strana=brojStrane;
        
        ajaxZahtev("moduless/proizvodi/filterProizvodi.php",trentuniFilteri,function(res){
            ispisProizvoda(res.proizvodi,"#proizvodi",4);
            
        })
}
function paginacijaPrelazAdmin(e){
    e.preventDefault();
    ajaxZahtev("moduless/administrator/paginacijaAdmin.php",{strana:$(this).data("strana"),},function(res){
        ispisProizvodaAdmin(res.proizvodi);
    })
    $(".page-item").removeClass("active");
    $(this).parent().addClass("active");
}
function ispisProizvodaAdmin(arr){
    const target=document.querySelector("#proizvodAdmin");
    let html="";
    for(let i of arr){
        html+=`<tr>
        <td>${i.id}</td>
        <td>${i.imeProizvoda}</td>
        <td>${i.kategorija}</td>
        <td>${i.cena}</td>
        <td>${i.datumUnosa}</td>
        <td><a href="proizvodIzmena.php?id=${i.id}"><i class="fa fa-pencil"></i></a><a href="#" class="obrisiBtn ml-1" data-delId="${i.id}"><i class="fa fa-close adminDel"></i></a></td>
        </tr>`;
    }
    target.innerHTML=html;
}
function proizvodProvera(){
    let ok=true;
    const postObj={};
    const noveSpec=[];
    const specifikacije=[...document.querySelectorAll(".specifikacija")];
    const skrivene=document.querySelectorAll(".skrivenaSpec");
    if(proveraIzraza($("#izmenaNaziv"),nazivRegex)){
        if($("#izmenaNaziv").val().trim()!=$("#skriveniNaziv").val().trim()){
            postObj.naziv=$("#izmenaNaziv").val().trim()
        }
    }
    else{
        ok=false;
    }
    if(proveraIzraza($("#izmenaOpis"),opisRegex)){
        if($("#izmenaOpis").val().trim()!=$("#skriveniOpis").val().trim()){
            postObj.opis=$("#izmenaOpis").val().trim();
        }
    }
    else{
        ok=false;
    }
    if(proveraIzraza($("#izmenaCena"),cenaRegex)){
        if($("#izmenaCena").val().trim()!=$("#skrivenaCena").val().trim()){
            postObj.cena=$("#izmenaCena").val().trim()
        }
    }
    else{
        ok=false;
    }
    if($("#izmenaKat").val()!=$("#skrivenaKat").val()){
        postObj.kategorija=$("#izmenaKat").val();
    }
    for(let i in specifikacije){
        const item={};
        if(specifikacije[i].dataset.specid=="4"){
            if(proveraIzraza($(`#${specifikacije[i].id}`),materijalRegex)){
                if($(`#${specifikacije[i].id}`).val()!=skrivene[i].value){
                    item.specId=specifikacije[i].dataset.specid;
                    item.vrednost=specifikacije[i].value;
                    noveSpec.push(item);
                }
            }
            else{
                ok=false;
            }
        }
        else{
            if(proveraIzraza($(`#${specifikacije[i].id}`),specRegex)){
                if($(`#${specifikacije[i].id}`).val()!=skrivene[i].value){
                    item.specId=specifikacije[i].dataset.specid;
                    item.vrednost=specifikacije[i].value;
                    noveSpec.push(item);
                }
            }
            else{
                ok=false;
            }
        }
        
    }
    if(!jQuery.isEmptyObject(noveSpec)){
        postObj.spec=noveSpec;
    }
    return {ok,postObj};
}
function dodavanjeProizvoda(){
    var postObj=new FormData();
    let ok=true;
    const specifikacijeInputs=[...document.querySelectorAll(".addSpec")].filter(spec=>spec.value!="");
    const addSpec=[];
    const slikaInput=document.querySelector("#addSlika");
    proveraIzraza($("#addNaziv"),nazivRegex) ? postObj.append("naziv",$("#addNaziv").val()) :  ok=false;
    proveraIzraza($("#addOpis"),opisRegex) ? postObj.append("opis",$("#addOpis").val()) :  ok=false;
    proveraIzraza($("#addCena"),cenaRegex) ?  postObj.append("cena",$("#addCena").val()) : ok=false;
    if($("#addKat").val()!=""){
        postObj.append("kategorija",$("#addKat").val());
        $("#addKat").next().empty();
    }
    else{
        ok=false;
        $("#addKat").next().html("Molimo vas izaberite kategoriju");
    }
    for(let i of specifikacijeInputs){
        const item={};
        if(i.id=="addMaterijal"){
            if(proveraIzraza($(`#${i.id}`),materijalRegex)){
                item.specId=i.dataset.karakid;
                item.vrednost=i.value;
                addSpec.push(item);
            }
            else{
                ok=false;
            }
        }
        else{
            if(proveraIzraza($(`#${i.id}`),specRegex)){
                item.specId=i.dataset.karakid;
                item.vrednost=i.value;
                addSpec.push(item);
            }
            else{
                ok=false;
            }
        }
        
    }
    if(addSpec.length>=3){
        const stringSpec=JSON.stringify(addSpec);
        postObj.append("spec",stringSpec);
        $(".addSpec").parent().find(".greska").empty();
    }
    else{
        const prazneSpec=[...document.querySelectorAll(".addSpec")].filter(spec=>spec.value=="");
        for(let i of prazneSpec){
            $(i).parent().find(".greska").html("Molimo vas popunite polje");
        }
        ok=false;
    }
    if(slikaRegex.test(slikaInput.files[0].type)){
        const upload=slikaInput.files[0];
        postObj.append("slika",upload);
        $("#addSlika").parent().find(".greska").empty();
    }
    else{
        $("#addSlika").parent().find(".greska").html("Slika nije u dobrom formatu");
        ok=false;
    }
    if(ok){
        postObj.append("add",true);
        $.ajax({
            url:"moduless/administrator/dodavanjeProizvoda.php",
            method:"POST",
            contentType: false,
            cache: false,
            processData:false,
            data:postObj,
            success:function(res){
                
                const link=` <span>Uspeno ste dodali proizvod.<a href="proizvod.php?id=${res}">Pogledaj proizvod</a></span><i class="fa fa-close text-right ml-5" id="uspehClose"></i>`;
                $(".uspesnoDodat").html(link).fadeIn();
                $("#dodavanjeGreske").fadeOut();
                $("#uspehClose").click(function(){
                $(".uspesnoDodat").fadeOut();
                    
                })
            },
            error:function(xhr){
                console.log(xhr);
                const greske=xhr.responseJSON;
                let html="";
                for(let i of greske){
                    html+=`<li>${i}</li>`;
                }
                $(".uspesnoDodat").fadeOut();
                $("#dodavanjeGreske").html(html).fadeIn();
            }
        })
    }
}
function anketaProvera(){
    let odgovoreno=false;
    const odgovori=document.querySelectorAll("input[name=odgovor]");
    for(let i of odgovori){
        if(i.checked){
            odgovoreno=true;
            break;
        }
    }
    if(odgovoreno){
        return true;
    }
    $("#formaAnketa").find(".greska").addClass("d-block");
    return false;
}
function anketaKorisnik(){
    $("#formaAnketa").find(".greska").addClass("d-block").html("Morate se prijaviti da biste glasali");
    return false;
}
var myChart;
function ispisGrafika(odgovori,rezultati){
    const grafik = document.getElementById('grafik').getContext('2d');
    // if(myChart!=undefined){
    //     window.myChart.destroy();
    // }
    myChart = new Chart(grafik, {
        type: 'bar',
        //label:odgovori,
        data: {
            labels: odgovori,
            datasets: [{
                label: 'Broj glasova',
                data: rezultati,
                backgroundColor: "orange"
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

}
function dohvatiGrafik(grafikObj){
    ajaxZahtev("moduless/administrator/anketaRezultati.php",grafikObj,function(res){
        const rezultati=res.rez.map(rez=>rez.broj);
        const odgovori=res.odg.map(odg=>odg.tekst);
        if(myChart!=undefined){
            myChart.destroy();
        }
        ispisGrafika(odgovori,rezultati);
    })
}
function odgovori(){
    const anketaId=document.querySelector("#izmenaAnketeDdl").value;
    const izmnenaObj={
        id:anketaId,
        rez:"OK"
    }
    ajaxZahtev("moduless/administrator/anketaRezultati.php",izmnenaObj,function(res){
    ispisOdgovora(res.odg);
    })
    function ispisOdgovora(arr){
        const target=document.querySelector("#odgovori");
        let html="";
        for(let i in arr){
            html+=` <div class="form-group">
            <input type="text" id="odg${i}" data-id="${arr[i].id}" class="form-control izmenaOdg clearFocus" value="${arr[i].tekst}" />
            <p class="greska text-danger"></p>
            <input type="hidden" id="odg${i}" data-id="${arr[i].id}" class="form-control originalOdg" value="${arr[i].tekst}" />
            </div>`;
        }
        target.innerHTML=html;
        target.innerHTML+=`<ul class="anketaIzmenaMsg text-center"></ul>`;
        
    }
}
function dodajOdgInput(target,identifikator){
    const targetNode=document.querySelector(target);
    const div=document.createElement("div");
    div.setAttribute("class","form-group");
    div.innerHTML+=`
        <input type="text" class="form-control ${identifikator}" name="odg" />
        <p class="greska text-danger"></i></p>`;
    targetNode.appendChild(div);
}
function dodajAnketuProvera(){
    let ok=true;
    const pitanjeRegex=/^[A-Z][A-z0-9\s\,\.\?\!]{1,79}$/;
    const odgovoriNiz=[];
    const odgovori=[...$(".odg")].filter(elem=>elem.value!="");
    const odgovoriPrazni=[...document.querySelectorAll(".odg")].filter(elem=>elem.value=="");
    if(!proveraIzraza($("#pitanje"),pitanjeRegex)){
        ok=false;
    }
    for(let i of odgovori){
        if(!proveraIzraza($(i),odgRegex)){
            ok=false;
        }
        else{
            odgovoriNiz.push(i.value);
        }
    }
    if(odgovoriNiz.length<2){
        for(let i of odgovoriPrazni){
            i.nextElementSibling.innerHTML="Molimo vas popunite ovo polje";
        }
        ok=false;
    }
    if(ok){
        postObj={
            pitanje:$("#pitanje").val(),
            odgovori:odgovoriNiz,
            dodaj:"ok"
        }
        ajaxZahtev("moduless/administrator/dodavanjeAnkete.php",postObj,function(res){
            $(".anketaPoruka").removeClass("text-danger").addClass("text-success").html(`<li>${res}</li>`);
        },
        function(xhr){
            const greske=xhr.responseJSON;
            
            let html=""
            for(let i of greske){
                html+=`<li>${i}</li>`;
            }
            $(".anketaPoruka").addClass("text-danger").html(html);
        })
    }
}
function izmenaOdgovora(){
    const odgovori=[...document.querySelectorAll(".izmenaOdg")];
    const orignalOdg=document.querySelectorAll(".originalOdg");
    const nizOdgovora=[];
    for(let i in odgovori){
        const item={};
        if(proveraIzraza($(odgovori[i]),odgRegex) && odgovori[i].value!=orignalOdg[i].value){
            item.id=odgovori[i].dataset.id;
            item.noviOdg=odgovori[i].value;
            nizOdgovora.push(item);
        }
    }
    if(nizOdgovora.length){
        ajaxZahtev("moduless/administrator/anketaIzmena.php",{odgovori:nizOdgovora,izmena:true},function(res){
            $(".anketaIzmenaMsg").html(`<li class="text-success">Izmena ankete je uspela</li>`);
        },function(xhr){
            const greske=xhr.responseJSON;
            let html="";
            for(let i of greske){
                html+=`<li class="text-danger">${i}</li>`;
            }
            $(".anketaIzmenaMsg").html(html);
            $("#odgovori")[0].reset();
        })
    }
}
