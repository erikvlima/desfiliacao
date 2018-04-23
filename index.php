<?php
include "CidadeEstado.php";
include "Sindicato.php";

$conexao = new CidadeEstado();
$ufs = $conexao->getEstados();
$conexao2 = new Sindicato();
$sind = $conexao2->getSindicatos();
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Desfiliação de Sindicato</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/selectize.css"/>

</head>
<body>
<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/selectize.js"></script>
<script type="text/javascript" src="js/jquery.mask.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<div class="form-group"><h3>Desfiliação de Sindicato</h3></div>
<form action="index.php" method="post">

    <div class="form-group">Sindicato</div>
    <div>
        <select name="sindicato" id="sindicato" required="required" style="width:400px;">
            <option value="">Escolha o Sindicato</option>
            <?php foreach ($sind as $s) {?>
                <option value="<?php echo $s->sind_nome?>" id="sind"><?php echo $s->sind_nome ?></option>
            <?php }?>
        </select>

    </div>
    <div class="form-group">E-mail do Sindicato</div>
    <div class="form-group"><input type="text" name="email_sindicato" id="email_sindicato" class="form-control" style="width:400px;"></div>

    <div class="form-group">Nome Completo</div>
    <div class="form-group"><input type="text" name="nome" id="nome" class="form-control" style="width:400px;"></div>

    <div class="form-group">Razão Social</div>
    <div class="form-group"><input type="text" name="razao" id="razao" class="form-control" style="width:400px;"></div>

    <div class="form-group">CNPJ</div>
    <div class="form-group"><input type="text" name="cnpj" id="cnpj" PLACEHOLDER="XX.XXX.XXX/XXXX-XX" class="form-control" style="width:400px;"></div>

    <div class="form-group">Número Core</div>
    <div class="form-group"><input type="text" name="n_core" id="n_core" class="form-control" style="width:400px;"></div>

    <div class="form-group">E-mail</div>
    <div class="form-group"><input type="text" name="email" id="email" class="form-control" style="width:400px;"></div>

    <div class="form-group">Celular</div>
    <div class="form-group"><input type="text" name="celular" id="celular" placeholder="(XX) X XXXX-XXXX" class="form-control" style="width:400px;"></div>

    <div class="form-group">Segmento
    <div class="form-group"><input type="text" name="segmento" id="segmento" style="width:400px;"></div>

    <div class="form-group">UF</div>
    <div class="form-group">
        <select name="uf" id="uf" required="required" class="form-control" style="width:400px;">
            <option value="0">Escolha seu estado...</option>
            <?php foreach ($ufs as $uf) {?>
                <option value="<?php echo $uf->cod_estados?>" id="estados"><?php echo $uf->nome ?></option>
            <?php }?>
        </select>
    </div>
    <div class="form-group">Cidade</div>
    <div class="form-group">
        <select name="cidades" id="cidades" required="required" class="form-control" style="width:400px;">
            <option value="0">Primeiro escolha um estado...</option>
        </select>
    </div>
    <br>
    <div class="form-group">
    <input type="submit" id="BtnCadastrar" name="BtnCadastrar" value="Cadastrar" class="btn btn-primary">
    </div>
</form>
</body>
</html>
<script>
    $(function () {
        $('#sindicato').selectize({
            create: true,
            sortField: 'text'
        });
    });

    //$('#uf').selectize();

    $('#segmento').selectize({
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });

    $('#cnpj').mask('99.999.999/9999-99');
    $('#celular').mask('(99) 9 9999-9999');

    $('#uf').change(function () {
        if ($(this).val()) {
            $.ajax({
                type: 'POST',
                url: 'acoes.php',
                async: false,
                data: {
                    acao: 'busca-cidades-do-estado',
                    uf: $("#uf").val()
                },
                success: function (data) {
                    if (data != 'false') {
                        var dados = JSON.parse(data);
                        var a;
                        var options = '<option value="">Escolha uma cidade</option>';
                        for (a in dados) {
                            var cidade = dados[a];
                            options += "<option id='cities' value='" + cidade.nome + "'> " + cidade.nome + "</option>";
                        }
                        $('#cidades').html(options).show();
                       // $('#cidades').prop('disabled', false);
                        //$('#cidades').prop('class', false);
                        //$('#cidades').selectize();
                    } else {
                        alert(data);
                    }
                },
                error: function (data) {
                    alert(data);
                    console.log(data);
                }
            })
        } else {
            $('#cidades').html('<option value="">-- Escolha um estado --</option>');
        }
    })

    $('#sindicato').change(function () {
        if ($(this).val()) {
            $.ajax({
                type: 'POST',
                url: 'acoes.php',
                async: false,
                data: {
                    acao: 'busca-email-sindicato',
                    sind: $("#sindicato").val()
                },
                success: function (data) {
                    if (data != 'false') {
                        var dados = data;
                        $('#email_sindicato').val(dados);
                    } else {
                        alert(data);
                    }
                },
                error: function (data) {
                    alert(data);
                    console.log(data);
                }
            })
        }
    })

    function validarCNPJ(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g,'');

        if(cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }

</script>