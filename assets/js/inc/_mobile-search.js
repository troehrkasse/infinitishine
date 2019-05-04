
/**
 * Check to see if global event bus have already been defined by other vue widgets/apps. 
 * if not, define and instantiate a new bus.
 */
if(!bus){
    var bus = new Vue();
}

var vueAwesomeSearchMobile = new Vue({
    el:'#awesome-search-app-mobile',
    
    data:function(){
      return {
          placeholderText:'Search greenhouses, resources and accessories'
      } 
    },
    
    created:function(){
        var self = this;
        
        bus.$on('onAwesomeSearchSubmitted',function(event){self.onSearchSubmitted(event)});
        bus.$on('onAwesomeSearchSelected', function(args){self.onSearchSelected(args);});
    },
    
    methods:{
        onSearchSubmitted:function(event){
            var el = jQuery(event.target);
            if(el.closest('#awesome-search-app-mobile').length <=0)
                return event;
            
            var term = el.children('input').val(); 
            if(term.length > 0)
                window.location.href = BN_VARS.SITE_URL+'?s='+term;
        },
        onSearchSelected:function(args){ 
            var ele = jQuery(args.event.target);
            
            if(ele.closest('#awesome-search-app-mobile').length <=0)
                return args;
                
            if(!args.item)
                return args;
                
            window.location.href = args.item.link;
        }
    },
    
    components:{
        
    }
});