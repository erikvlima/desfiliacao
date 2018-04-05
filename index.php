<?php
include "Conexao.php";

$conn = new Conexao();
$ufs = $conn->getEstados();
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
        <select name="sindicato" id="sindicato" required="required" class="form-control" style="width:400px;">

        </select>
    </div>
    <div class="form-group">Nome Completo</div>
    <div class="form-group"><input type="text" name="nome" id="nome" class="form-control" style="width:400px;"></div>

    <div>Razão Social</div>
    <div><input type="text" name="razao" id="razao" class="form-control" style="width:400px;"></div>

    <div>CNPJ</div>
    <div><input type="text" name="cnpj" id="cnpj" class="form-control" style="width:400px;"></div>

    <div>Número Core</div>
    <div><input type="text" name="n_core" id="n_core" class="form-control" style="width:400px;"></div>

    <div>E-mail</div>
    <div><input type="text" name="email" id="email" class="form-control" style="width:400px;"></div>

    <div>Celular</div>
    <div><input type="text" name="celular" id="celular" class="form-control" style="width:400px;"></div>

    <div>Segmento</div>
    <div><input type="text" name="segmento" id="segmento" style="width:400px;"></div>

    <div>UF</div>
    <div>
        <select name="uf" id="uf" required="required" class="form-control" style="width:400px;">
            <option value="0">Selecione uma opção</option>
            <?php while ($obj = $ufs->fetch_object()) {?>
                <option value="<?php echo $obj->cod_estados?>" id="estados"><?php echo $obj->sigla ?></option>
            <?php }?>
        </select>
    </div>
    <div>Cidade</div>
    <div>
        <select name="cidades" id="cidades" required="required" class="form-control" style="width:400px;">
            <option value="0">Selecione uma opção</option>
        </select>
    </div>
    <br>
    <input type="submit" id="BtnCadastrar" name="BtnCadastrar" value="Cadastrar" class="btn btn-primary">

</form>
</body>
</html>
<script>
    $(function () {
        $('#sindicato').selectize();
    });

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
</script>