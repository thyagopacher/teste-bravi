<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Listar Informações</title>
  <meta name="description" content="The small framework with powerful features">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
  <style>
    .fa-times {
      color: red;
    }

    .fa-check {
      color: green;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="text-center">Listar Informações</h1>
    <div id="divBusca" class="row col-md-12">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">Filtro:</span>
        </div>
        <input type="text" class="form-control" name="myInput" id="myInput" placeholder="Digite sua busca pelo nome...">
        <button id="btAdicionar" class="btn btn-primary">
          <i class='fas fa-plus'></i>
          Adicionar
        </button>
      </div>
    </div>
    <div class="row col-md-12">
      <table id="listaContatosTable" class="display" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>WhatsAPP</th>
            <th>Dt. Cadastro</th>
            <th>Opções</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>WhatsAPP</th>
            <th>Dt. Cadastro</th>
            <th>Opções</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Formulário de Cadastro</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" id="form_dados_contato" onsubmit="return false">
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" maxlength="255" required placeholder="Digite nome" name="nome" id="nome">
            </div>
            <div class="form-group">
              <label>E-mail</label>
              <input type="email" class="form-control" maxlength="255" placeholder="Digite email" name="email" id="email">
            </div>
            <div class="form-group">
              <label>Telefone</label>
              <input type="text" class="form-control" maxlength="11" placeholder="Digite telefone" name="telefone" id="telefone">
            </div>
            <div class="form-group">
              <label>WhatsAPP</label>
              <input type="text" class="form-control" maxlength="11" placeholder="Digite whatsapp" name="whatsapp" id="whatsapp">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
          <button type="button" id="btnSalvarContato" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

  <script type="text/javascript">
    let tabelaDatatable = null;
    $(function() {

      let urlFind = 'http://' + location.hostname + location.pathname + '/get';
      tabelaDatatable = $('#listaContatosTable').DataTable({
        dom: 'Bfrtip',
        ajax: urlFind,
        buttons: [
          'copy', 'excel', 'pdf', 'print'
        ],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        columns: [{
            "data": "id"
          },
          {
            "data": "nome"
          },
          {
            "data": "telefone"
          },
          {
            "data": "email"
          },
          {
            "data": "whatsapp"
          },
          {
            "data": "data",
            "render": function(value) {
              if (value === null) return "";

              let separaData1 = value.split(' ');
              let separaData2 = separaData1[0].split('-');

              return separaData2[2] + "/" + separaData2[1] + "/" + separaData2[0] + ' ' + separaData1[1];
            }
          },
          {
            "data": "id",
            "render": function(value) {
              let htmlBotao = '';

              htmlBotao += `<a onclick="abrirForm(${value})" class='btEditar btn btn-primary' codigo='${value}' title='Alterar contato'><i class='fas fa-edit'></i></a>`;
              htmlBotao += `<a onclick="excluirContato(${value})" class='btExcluir btn btn-danger' codigo='${value}' title='Excluir contato'><i class='fas fa-minus-circle'></i></a>`;

              return htmlBotao;
            }
          }
        ],
        "initComplete": function(settings, json) {
          console.log('Carregamento completo');
        }
      });

      $("#btnSalvarContato").click(function() {
        salvarContato();
      });

      $("#myInput").keyup(function() {
        filtrarTabela();
      });

      $("#btAdicionar").click(function() {
        $("#form_dados_contato input").val('');
        abrirForm();
      });
    });

    function excluirContato(id) {
      let urlRequisicao = 'http://' + location.hostname + location.pathname;
      if (id != undefined && id != null && id != "") {
        swal({
            title: "Você tem certeza disto?",
            text: "Após excluir, os dados não poderão mais ser recuperados!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                url: urlRequisicao + 'delete',
                dataType: 'json',
                method: 'post',
                data: {
                  id: id
                },
                success: function(result) {
                  if (result.status) {
                    swal('Exclusão', result.mensagem, 'success');
                    /** 
                     * atualiza a tela para os dados
                     */
                    setTimeout(function() {
                      location.reload();
                    }, 1500);
                  } else {
                    swal('Exclusão', result.mensagem, 'error');
                  }
                }
              });
            }
          });
      }
    }

    function abrirForm(id) {
      $(".modal-title").html('<i class="fas fa-user"></i> Adicionando novo contato');
      if (id != undefined && id != null && id != "") {
        $(".modal-title").html('<i class="fas fa-user"></i> Edição de informações do contato');
        procurarContato(id, abrirModal);
      } else {
        abrirModal();
      }
    }

    function abrirModal() {
      $("#myModal").modal();
    }


    function salvarContato() {
      if ($("#nome").val() == undefined || $("#nome").val() == null || $("#nome").val() == "") {
        swal('Atenção', 'Por favor preencher campo de nome!', 'info');
        $("#nome").focus();
      } else {
        let dados = {};
        let estaEditando = $("#id").val() != undefined && $("#id").val() != null && $("#id").val() != "";
        let urlRequisicao = 'http://' + location.hostname + location.pathname;
        if (estaEditando) {
          urlRequisicao += '/update';
        } else {
          urlRequisicao += '/create';
        }
        $.ajax({
          url: urlRequisicao,
          dataType: 'json',
          method: 'post',
          data: $("#form_dados_contato").serialize(),
          success: function(result) {
            if (result.status) {
              swal('Cadastro', result.mensagem, 'success');
              /** 
               * atualiza a tela para os dados
               */
              setTimeout(function() {
                location.reload();
              }, 1500);
            } else {
              swal('Cadastro', result.mensagem, 'error');
            }
          }
        });
      }
    }

    function procurarContato(id, eventosPosteriores) {
      let dados = {};
      let estaEditando = id != undefined && id != null && id != "";
      let urlFind = 'http://' + location.hostname + location.pathname + '/get';
      if (estaEditando) {
        urlFind += '/' + id;
      }
      $.ajax({
        url: urlFind,
        dataType: 'json',
        method: 'get',
        data: dados,
        success: function(result) {
          if (estaEditando) {
            $.each(result.data[0], function(i, item) {
              if ($(`#${i}`).length) {
                $(`#${i}`).val(item);
              }
            });
          }
          if (eventosPosteriores != undefined && eventosPosteriores != null) {
            eventosPosteriores();
          }
        }
      });
    }

    /** 
     * para filtrar na tabela pelo nome
     */
    function filtrarTabela() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("listaContatosTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
</body>

</html>