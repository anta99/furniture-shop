$(document).ready(function(){
    $(".regBtn").click(registracijaProvera);
})
const imeRegex=/^[A-Z][a-z]{2,9}(\s[A-Z][a-z]{2,9})*$/;
const prezimeRegex=/^[A-Z][a-z]{4,19}(\s[A-Z][a-z]{2,19})*$/;
const adresaRegex=/^[A-Z][a-z0-9]{3,29}(\s[A-z0-9]{1,19})*$/;
const gradRegex=/^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,14})*$/;
const telRegex=/^06[0-59][0-9]{6,8}$/;
const korImeRegex=/^[A-z][A-z0-9\.\?\!]{3,59}$/;
const mailRegex=/^[a-z0-9\.\?]{4,}\@([a-z0-9]{3,}\.)*[a-z]{2,3}$/;
const lozinkaRegex=/^[\w\W\s]{6,}$/;

function proveraIzraza(target,regex){
    if(!regex.test(target.val().trim())){
        target.next().html("Molimo vas ispravno popunite ovo polje");
        return 0;
    }
    else{
        target.next().html("");
        return 1;
    }
}
function registracijaProvera(e){
    e.preventDefault();
    let ok=true;
    if(!proveraIzraza($("#ime"),imeRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#prezime"),prezimeRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#adresa"),adresaRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#grad"),gradRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#tel"),telRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#korIme"),korImeRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#regMail"),mailRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#regPass"),lozinkaRegex)){
        ok=false;
    }
    if(ok){
        $.ajax({
            url:"moduless/prijave/registracija.php",
            method:"POST",
            dataType:"json",
            data:{
                ime:$("#ime").val(),
                prezime:$("#prezime").val(),
                adresa:$("#adresa").val(),
                grad:$("#grad").val(),
                tel:$("#tel").val(),
                korIme:$("#korIme").val(),
                regMail:$("#regMail").val(),
                regPass:$("#regPass").val(),
                regBtn:"OK"
            },
            success:function(res){
                $(".regPoruka").removeClass("alert-danger").addClass("alert-success").html(res);
                
            },
            error:function(xhr){
                $(".regPoruka").removeClass("alert-success").addClass("alert-danger").html(xhr.responseJSON);
            }
        })
    }
    //return ok;
}
function prijavaProvera(){
    let ok=true;
    if(!proveraIzraza($("#logIme"),korImeRegex)){
        ok=false;
    }
    if(!proveraIzraza($("#logPass"),lozinkaRegex)){
        ok=false;
    }
    return ok;
}