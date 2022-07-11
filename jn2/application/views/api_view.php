<html>
<head>
    <title>TESTE TÉCNICO</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">CRUD SIMPLES - JN2</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">CLIENTES</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Adicionar</button>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
            <div class="input-group rounded">
                    <input type="number" id='pesquisa' class="form-control rounded" placeholder="Placas por final" minlength="1" maxlength="1" aria-label="Search" aria-describedby="search-addon" />
                </div>
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>CPF</th>
                            <th>Placa</th>
                            <th>Editar</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Adicionar</h4>
                </div>
                <div class="modal-body">
                    <label>Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" />
                    <span id="erro_nome" class="text-danger"></span>
                    <br />
                    <label>Telefone</label>
                    <input type="text" name="telefone"  onkeydown="return mascaraTelefone(event)" id="telefone" placeholder="(99)99999-9999" class="form-control" />
                    <span id="erro_telefone" class="text-danger"></span>
                    <br />
                    <label>CPF</label>
                    <input type="text" oninput="mascaraCPF(this)" name="cpf" id="cpf" placeholder="123.456.789-00" class="form-control" />
                    <span id="erro_cpf" class="text-danger"></span>
                    <br />
                    <label>Placa</label>
                    <input type="text" name="placa_carro" id="placa_carro" onkeyup="mascaraPlaca(this)" placeholder="ABC-1234" maxlength="8" class="form-control" />
                    <span id="erro_placa" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="usuario_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>api/cliente",
            method:"POST",
            data:{data_action:'Listar_todos'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Adicionar Cliente");
        $('#action').val('Adicionar');
        $('#data_action').val("Insert");
        $('#userModal').modal('show');
    });

    $(document).on('submit', '#user_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'api/cliente' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Cadastrado com sucesso!</div>');
                    }
                }

                if(data.error)
                {
                    $('#nome').html(data.first_name_error);
                    $('#telefone').html(data.last_name_error);
                    $('#cpf').html(data.cpf);
                    $('#placa_carro').html(data.placa_carro);
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var usuario_id = $(this).attr('usuario_id');
        $.ajax({
            url:"<?php echo base_url(); ?>api/cliente",
            method:"POST",
            data:{usuario_id:usuario_id, data_action:'Buscar_um'},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#nome').val(data.nome);
                $('#telefone').val(data.telefone);
                $('#cpf').val(data.cpf);
                $('#placa_carro').val(data.placa_carro);
                $('.modal-title').text('Editar');
                $('#usuario_id').val(usuario_id);
                $('#action').val('Editar');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var usuario_id = $(this).attr('usuario_id');
        if(confirm("Tem certeza que deseja deletar?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>api/cliente",
                method:"POST",
                data:{usuario_id:usuario_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Deletado!</div>');
                        fetch_data();
                        setTimeout(() => {
                            $('#success_message').html('');

                        }, 1000);

                    }
                }
            })
        }
    });


    $(document).on('input', '#pesquisa', function(event){
        var final = $(this).val();
        if(final.length > 0){
            $.ajax({
                url:"<?php echo base_url(); ?>consulta/final_placa",
                method:"POST",
                data:{final:final},
                dataType:"JSON",
                success:function(data)
                {

                    $('tbody').html(data);

                },error:function(data){

                    $('#success_message').html('<div class="alert">Erro não catalogado!</div>');
                    fetch_data();

                }
            });
        }else{
            $('#success_message').html('');
            fetch_data();

        }
       
    });
    
});


function mascaraTelefone(event) {
    let tecla = event.key;
    let telefone = event.target.value.replace(/\D+/g, "");

    if (/^[0-9]$/i.test(tecla)) {
        telefone = telefone + tecla;
        var tamanho = telefone.length;

        if (tamanho >= 12) {
            return false;
        }
        
        if (tamanho > 10) {
            telefone = telefone.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (tamanho > 5) {
            telefone = telefone.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (tamanho > 2) {
            telefone = telefone.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            telefone = telefone.replace(/^(\d*)/, "($1");
        }

        event.target.value = telefone;
    }

    if (!["Backspace", "Delete"].includes(tecla)) {
        return false;
    }
}
function mascaraCPF(i){
   
   var v = i.value;
   
   if(isNaN(v[v.length-1])){ 
      i.value = v.substring(0, v.length-1);
      return;
   }
   
   i.setAttribute("maxlength", "14");
   if (v.length == 3 || v.length == 7) i.value += ".";
   if (v.length == 11) i.value += "-";

}
function mascaraPlaca(i) {
    var placa_carro = i.value; 
    
    if (placa_carro.length < 3 ||placa_carro.length > 3) {                       
        placaMaiuscula = placa_carro.toUpperCase();                      
        document.forms[0].placa_carro.value = placaMaiuscula;    
        return true;
    }

    if (placa_carro.length === 3){                                                        
        placa_carro += "-";       
                                                                  
        placaMaiuscula = placa_carro.toUpperCase();                 
        document.forms[0].placa_carro.value = placaMaiuscula; 
        return true;
    }
}
</script>