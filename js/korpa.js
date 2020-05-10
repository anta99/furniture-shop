// import {korpaBrojac} from "./main.js";
$(document).ready(function(){
    korpaBrojac();
    posaljiZahtev();
    $(document).on("click",".manje",function(){
        const staraKolicina=Number($(this).parent().find(".kolicina").html());
        let novaKolicina;
        if(staraKolicina>=1){
            novaKolicina=staraKolicina-1;
        }
        $(this).parent().find(".kolicina").html(novaKolicina);
        ukupnaCena();
    })
    $(document).on("click",".vise",function(){
        const staraKolicina=Number($(this).parent().find(".kolicina").html());
        let novaKolicina;
        novaKolicina=staraKolicina+1;
        $(this).parent().find(".kolicina").html(novaKolicina);
        ukupnaCena()
    })
    $(document).on("click",".remove",function(){
        izbrisiIzLS(this.dataset.removeid);
        $(this).parent().remove();
        korpaBrojac();
        ukupnaCena(); 
    });
    $("input[name=adresa]").change(function(){
       const izabrano=this.value;
       if(izabrano=="druga"){
           $(".nove").removeClass("d-none");
       }
       else{
        $(".nove").addClass("d-none");
       }
    })
    $("#kupi").click(function(e){
        if(JSON.parse(localStorage.getItem("korpa")).length!=0){
            $('#kupovinaModal').modal();
            modalIspis();
            const cena=$("#ukupno").html();
            $("#cenaModal").html(cena);
        }
        else{
            alert("Nemate proizvoda u korpi");
            return;
        }
        console.log(cena);
    })
    $("#potvrdi").click(function(){
        const kolicine=document.querySelectorAll(".tabelaKolicina");
        const cene=[...document.querySelectorAll(".tabelaNaziv")];
        let porudzbinaObj=[];
        for(let i in cene){
            const stavka={
                id:cene[i].dataset.id,
                kolicina:kolicine[i].innerHTML,
                cena:cene[i].dataset.cena
                // kupacId:this.dataset.kupac,
            };
            porudzbinaObj.push(stavka);
        }
        console.log(porudzbinaObj);
        $.ajax({
            url:"moduless/korpa/porudzbina.php",
            method:"POST",
            dataType:"json",
            data:{
                porudzbina:porudzbinaObj,
                kupac:$("#potvrdi").data("kupac"),
                adresa:$("#modalAdresa").html(),
                grad:$("#modalGrad").html(),
                dugme:"OK"
            },
            success:function(res){
                $('#kupovinaModal').modal('hide');
                if(res.res=="OK"){
                    $("#korpaIspis").html(`<div class="alert alert-success text-center p-4" role="alert" id="porudzbinaObv">
                    Vaša porudžbina je uspešno zavedena.
                  </div>`);
                }
                else{
                    $("#korpaIspis").html(`<div class="alert alert-danger text-center p-4" id="porudzbinaObv" role="alert">
                   Nažalost je došlo do greške.Molimo vas pokušajte kasnije.
                  </div>`);
                }
                $(".ukupnaCena").html("");
                localStorage.removeItem("korpa");
                korpaBrojac();
            },
            error:function(xhr){
                console.log(xhr);
            }
        })
    })
    
})
//console.log(JSON.parse(localStorage.getItem("korpa")));
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
function posaljiZahtev(){
    const korpa=JSON.parse(localStorage.getItem("korpa"));
    if(korpa!=null){
        const proizvodiId=korpa.map(proizvod=>proizvod.id);
        //console.log(proizvodiId);
        $.ajax({
            url:"moduless/korpa/korpaProizvodi.php",
            method:"POST",
            dataType:"json",
            data:{
                korpa:proizvodiId
            },
            success:function(res){
                //console.log(res);
                korpa.sort((a,b)=>a.id-b.id);
                for(let i in res.res){
                    res.res[i].kolicina=korpa[i].kolicina;
                }
                ispisKorpe(res.res);
            },
            error:function(xhr){
                console.log(xhr);
            }
        })
    }
    else{
        ispisKorpe(korpa);
    }
    
}
function ispisKorpe(arr){
    const korpaIspis=document.querySelector("#korpaIspis");
    let html="";
    if(arr!=null){
        if(arr.length!=0){
            for(let i of arr){
                html+=` <article class="position-relative row jedanArtikal mt-1">
                <div class="d-none d-md-block col-3 mx-auto text-left">
                   <img src="images/${i.src}" alt="${i.alt}" />
                </div>
                <div class="position-relative col-12 col-md-3  mx-auto text-center nazivProizvoda kat">
                <p class="abs">Ime proizvoda</p>
                <h2>${i.imeProizvoda}</h2>
                </div>
                <div class=" position-relative col-7 col-md-3 text-center kat">
                    <p class="abs">Kolicina</p>
                    <button type="button" class="btn dugme manje">-</button>
                    <span class="kolicina">${i.kolicina}</span>
                    <button type="button" class="btn dugme vise">+</button>
                </div>
                <div class=" position-relative col-5 col-md-3  text-center kat">
                   <p class="abs">Cena</p>
                    <p class="font-weight-bold korpaCena d-inline ml-2 pt-5"><span class="jedCena">${i.cena}</span> RSD</p>
                </div>
                <i class="fa fa-close remove text-right ml-5" data-removeid="${i.id}"></i>
            </article>`;
            }
        }
    }
    else{
        html+=`<h3 class="text-center praznaKorpa mx-5 d-block">Vasa korpa je trenutno prazna</h3>
            <a class="text-center mx-auto d-block nazadKup" href="proizvodi.php">Vrati se na kupovinu</a>
        `;
        $(".ukupnaCena").hide();
    }
    korpaIspis.innerHTML=html;
    ukupnaCena();
}

function izbrisiIzLS(id){
    let korpa=JSON.parse(localStorage.getItem("korpa"));
    korpa=korpa.filter(artikal=>artikal.id!=id);
    const novaKorpa=JSON.stringify(korpa);
    localStorage.setItem("korpa",novaKorpa);
}
function ukupnaCena(){
    const sveCene=document.querySelectorAll(".jedCena");
    const kolicine=document.querySelectorAll(".kolicina");
    let sum=0;
    for(let i=0;i<sveCene.length;i++){
        sum+=Number(sveCene[i].innerHTML)*Number(kolicine[i].innerHTML);
    }
    document.querySelector("#ukupno").innerHTML=sum;
}
function modalIspis(){
    const target=document.querySelector("#tabelaProizvoda");
    let html="";
    const proizvodi=[...document.querySelectorAll(".jedanArtikal .nazivProizvoda h2")];
    const kolicina=document.querySelectorAll(".jedanArtikal .kolicina");
    const cena=document.querySelectorAll(".jedanArtikal .jedCena");
    const ids=document.querySelectorAll(".remove");
    for(let i in proizvodi){
        if(kolicina[i].innerHTML!="0"){
            html+=`<tr>
            <td data-id="${ids[i].dataset.removeid}" data-cena="${cena[i].innerHTML}" class="tabelaNaziv">${proizvodi[i].innerHTML}</td>
            <td class="tabelaKolicina">${kolicina[i].innerHTML}</td>
            </tr>`;
        }
        
    }
    target.innerHTML=html;
}