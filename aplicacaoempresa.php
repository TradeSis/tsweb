<!--#1 - Chamada html, direcionando para webix, css e jquery-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<script src="/ts/js/jquery/jquery.min.js" type="text/javascript"></script>	
	<script type="text/javascript"          src="/ts/js/webix/codebase/webix.min.js"></script>

	<link rel="stylesheet" type="text/css" href="/ts/js/webix/codebase/skins/flat.min.css">


	<style>
		</style>

	<script>

var wURL = '';

function chamaAJAX(wURL,wType="get",wdataType="json") {
    var res = [];

    $.ajax({
			url: wURL,
			type: wType,
			async: false,

			dataType: wdataType,
		
			success: function (json_get) {
				res = json_get;
			},
			error: function (xhr, status, errorThrown) {

				alert("errorThrown=" + errorThrown);
			}
		})
		return res;
	}


let clearAplicacaoEmpresa = () => {                             
    webix.confirm({
        title:"All data will be lost!",
        text:"Are you sure?"
    }).then(
        () => {
            
            $$("form_aplicacaoEmpresa").clear();               
            $$("form_aplicacaoEmpresa").clearValidation();     
        }
)};

 
let saveAplicacaoEmpresa = () => {                               
    let form = $$( "form_aplicacaoEmpresa" );                    
    let list = $$( "table_aplicacaoEmpresa" );                     
    let item_data = $$("form_aplicacaoEmpresa").getValues();     

    if( form.isDirty()){
      
        if( item_data.id ) 
            list.updateItem(item_data.id, item_data);
        else 
            list.add( item_data );
    }
	$$("win_aplicacaoEmpresa").hide();                             
   
}

var wTitulo = {
          "view": "label",
          "label": "Aplicação Empresa.",
          "id": "wTitulo",
          "height": 0
        };

var wToolbar = {
          "id": "wToolbar",
          "height": 34,
          "view": "toolbar",
          "css": "webix_dark",
          "padding": {
            "right": 20,
            "left": 20
          },
          "elements": [
               wTitulo 

          ]

        };

var wPesquisa = {
        "id": "wPesquisa",
        "height": 100,
        "view": "form",
        "minHeight": 380,
        "autoheight": false,
        "elements": [
          {
            "cols": [
              {
                "label": "Parametros",
                "view": "button",
                "height": 0,
                click:function(){ showForm("win1", this.$view) }
              },
			  {
                "label": "Inclusão",
                "view": "button",
				"width":120,
                "height": 0,
                click:function(){ showForm("win_aplicacaoEmpresa");
                  $$("empresa").define("disabled", false); }                      
              }
            ]
          }
        ]
      };

var wDtinicial = { id:"dtinicial","view": "datepicker", "height": 0 ,
              
               stringResult:true, 	icons: true};
var wDtfinal   = { id:"dtfinal","view": "datepicker", "height": 0 ,	
               
              stringResult:true, icons: true};

var form = {
  id:"formulario",
  view:"form",
  autowidth:true,
  borderless:true,
  "rows": [
		{
			"height": 58,
			"cols": [ wDtinicial, wDtfinal
			]
		},
		{ view:"button", value: "Pesquisa", click:function(){
        
               
                 
                   conteudo = $$("dtinicial").getText() + " TO " + $$("dtfinal").getText();
                   alert(conteudo);
                   
                  executa(conteudo);
                  $$("win1").hide();
                }
   }
	],
  elementsConfig:{
    labelPosition:"top",
  }
};

const table_aplicacaoEmpresa = {                 
    view:"datatable", 
    id:"table_aplicacaoEmpresa",
    scroll:"y",
    select:true,
    hover:"myhover",
    save:"aplicacaoempresa_save.php", 

    columns:                          
        [
            {
              "id": "empresa",                     
              "header": "empresa",
              "sort": "string",
              "width":200
            },
            {
              "id": "aplicacao",
              "header": "aplicacao",
              "sort": "string",
              "width":250
            }
          ,       
        { header:"", template:"<span class='webix_icon wxi-close delete_icon'></span>", width:35}
    ],
    onClick:{
        delete_icon(e, id){
        this.remove(id);
        return false;
        }
    },
    on:{
		onItemDblClick(id, e, node) {

			let values = $$("table_aplicacaoEmpresa").getItem(id);       
	
			  showForm("win_aplicacaoEmpresa");
			
            $$("form_aplicacaoEmpresa").setValues(values);

		},
        onAfterSelect(id){
			
		   webix.message("Click on row: " + id.row+", column: " + id.column);
            	
        }
    }
}

const form_aplicacaoEmpresa = {                                   
    view:"form", 
    id:"form_aplicacaoEmpresa", 
	autowidth:true,
  borderless:true,
 
    elements:[                                               
        { type:"section", template:"Aplicação para Empresa", disabled:true},
        { view:"text", name:"empresa", label:"empresa", disabled:true},
        { view:"text", name:"aplicacao", label:"Aplicação",},
        
      
        {
            margin:10, cols:[
                { view:"button", id:"btn_save", value:"Save",click:saveAplicacaoEmpresa},           
                { view:"button", id:"btn_clear", value:"Clear", click:clearAplicacaoEmpresa}
                
            ]
        },
        {}
    ]
}

var wPrincipal =
          { "id": "wPrincipal",
            "rows": [
                      wPesquisa , 
                      
					  {cols: 
                        [table_aplicacaoEmpresa]                         
                      }
            ]

          };
2
var wBarraEsquerda =
      {
        "view": "sidebar",
        "data": [
      		{
      			"value": "Amigos",
      			"icon": "wxi-check"
      		},
      		{
      			"value": "News",
      			"icon": "wxi-dots"
      		},
      		{
      			"value": "Photos",
      			"icon": "wxi-alert"
      		},
      		{
      			"value": "Messages",
      			"icon": "wxi-folder"
      		},
      		{
      			"value": "Settings",
      			"icon": "wxi-file"
      		}
      	],
        "width": 163,
        "id": "wFiltros"
      };

var wBarraDireita =  {
              "id": "wBarraDireita",
              "view": "sidebar",
              collapsed:true   ,
              "data": [
            		{
            			"value": "Amigos 2",
            			"icon": "wxi-check"
            		},
            		{
            			"value": "News",
            			"icon": "wxi-dots"
            		},
            		{
            			"value": "Photos",
            			"icon": "wxi-alert"
            		},
            		{
            			"value": "Messages",
            			"icon": "wxi-folder"
            		},
            		{
            			"value": "Settings",
            			"icon": "wxi-file"
            		}
            	],
              "width": 152
            };

var wCorpo = {
      "id": "wCorpo",
      "height": 0,
      "type": "wide",
      "cols": [
                wBarraEsquerda,      
                wPrincipal,    
                { "rows":[
                  {  
                   padding: 2, 
                    view: "form",
                    cols:[
                      { view: "button", type: "icon", icon: "bars",
                       click: function(){
                         $$("wBarraDireita").toggle();
                       }
                      }
                    ]
                  },
                wBarraDireita ]}
      ]
    };

var ui = {
  responsive:true, 
    rows:[  wToolbar 
          , wCorpo   
         ]
    };

webix.ready(function(){

if (webix.CustomScroll)
      webix.CustomScroll.init();

webix.i18n.setLocale("pt-BR");

webix.ui({
  view:"popup",
  id:"win1",
  width:500,
  head:false,
  body:webix.copy(form)
});
 
webix.ui({                                                       
  view:"window",
  id:"win_aplicacaoEmpresa",                                       
  width:300,

      modal:true,
  position:"center",
  head:false,
  body:webix.copy(form_aplicacaoEmpresa)
});

 webix.ui.fullScreen();
 webix.ui(ui);


 var dtini = new Date();
 var dd = '01';
 var mm = String(dtini.getMonth() + 1).padStart(2, '0'); 
 var yyyy = dtini.getFullYear();
 $$("dtinicial").setValue(new Date(yyyy,mm - 1,dd));
 var periodo = dd + '/' + mm + '/' + yyyy;
 var hoje = new Date();
 var dd = String(hoje.getDate()).padStart(2, '0');
 var mm = String(hoje.getMonth() + 1).padStart(2, '0'); 
 var yyyy = hoje.getFullYear();
 $$("dtfinal").setValue(new Date(yyyy,mm - 1,dd));
 periodo += ' TO ' + dd + '/' + mm + '/' + yyyy;
 
 executa(periodo);

});

function showForm(winId, node){
$$(winId).getBody().clear();
$$(winId).show(node);
$$(winId).getBody().focus();
}

function executa(wvar){

  wJson = chamaAJAX("aplicacaoempresa_leitura.php");                         

  $$("table_aplicacaoEmpresa").clearAll();
  $$("table_aplicacaoEmpresa").parse(wJson.aplicacaoEmpresa);                                                
}


  
</script>


</head>
<body></body>
</html>