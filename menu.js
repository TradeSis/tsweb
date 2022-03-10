/* MENU TS/SERVICES */

var wMenuApps = {
  "value": "Apps",
  "id" : "wmApps",

  labelAlign:"right",
  config:{
    on: {
      onItemClick:function(id){
        $$("menuIframe").define("src", id);
      }
    }
  },
  "submenu": [
    { id:"/ts/tsservices/clientes.php", value: "Clientes"}
    
  ]
};



var wMenu = {
  "id": "wMenu",
  "data":[  
            
    wMenuApps
         ],

 // "layout": "x",
  "type": {
    "subsign": true
    ,
    autowidth:true
  },
  submenuConfig:{
    autowidth:true,
    autoheight:true
},
  "view": "menu",
  css:"myCss"
  
};


var wMenuBotoes = {
  "cols": [
    {
     "label": "usuario",
      "id":"btnusuario",
      "view": "button", 
       css:"btn_fundoazul"
    },
    {
      "label": "configuração",
      "view": "button",
       css:"webix_transparent"
    },
    {
      "label": "sair",
      "view": "button",
       css:"webix_transparent",
       
       on:{
        // the default click behavior that is true for any datatable cell
        "onItemClick":function(id, e, trg){ 
           // webix.message("Click on row: " + id.row+", column: " + id.column)
            var wURL = "/ts/matacookie.php";
           // alert(wURL);
            var wdestino = chamaAJAX (wURL);
          //  alert(wdestino);

            this.getTopParentView().hide(); //hide window
            if (wdestino == "/ts/dashboard"){
              window.location.href="/ts/login";
            } else {
              window.location.href=wdestino;
            }
            

        }
    }}],
  
    
  
  width:300
};
var wlogo =  { view: "label", label: "", width: 160, autoheight:true, css:'app-logo' };
var wlogoempresa =  { id:"logoempresa", view: "label", label: "tt", width: 160, autoheight:true};

var wcabec =
{
  "height": 50,
  "cols": [ wlogo, wMenu  , wlogoempresa,
            
            wMenuBotoes

  ]
};

var wframe = {
  "id": "menuIframe",
  "view": "iframe", 
  "multiview": true,
  animate:{ type:"flip", subtype:"vertical" },
  "disabled": false,
  "height": 0,
  "src": "" //"/ts/tsservices/clientes.php"
};

var ui = {
  responsive:true, 
    rows:[ wcabec,
           wframe
         ]
    };

    // CHAMA WEBIX
    webix.ready(function(){

      if (webix.CustomScroll)
    		webix.CustomScroll.init();

      // SETA WEBIX PARA BR
      webix.i18n.setLocale("pt-BR");
      // ATIVA UI
      webix.ui.fullScreen();
      webix.ui(ui);
      
      var wURL = "/ts/pegacookie.php";

      var wcookie = chamaAJAX (wURL);
      //alert(wcookie);
      var warraysplit = (wcookie.split('|'));

      var wempresa  = warraysplit[0];
     // alert(wempresa);
      var wusuario  = warraysplit[1];
      $$("logoempresa").define("label",wempresa);
      $$("logoempresa").refresh();
      $$("btnusuario").define("label", wusuario);
      $$("btnusuario").refresh();

      //document.getElementById("btnusuario").innerHTML = wusuario;

    });

    
    var wURL = '';

	function chamaAJAX(wURL) {
        var res = "";
        
         $.ajax({
                url: wURL,
                type: "get",
                async: false,

                dataType: "text",
              
                success: function (json_get) {

					        res = json_get;
                  
                },
                error: function (xhr, status, errorThrown) {

                    alert("errorThrown=" + errorThrown);
                }
            })
            return res;
        }
        
    
   

