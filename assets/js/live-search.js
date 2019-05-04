
/**
 * Check to see if global event bus have already been defined by other vue widgets/apps. 
 * if not, define and instantiate a new bus.
 */
if(!bus){
    var bus = new Vue();
}

var vueLiveSearchApp = new Vue({
    el:'#live-search-app',  
    
    data:function(){
      return {
          placeholderText:'Search greenhouses, resources and accessories'
      } 
    },
    
    created:function(){
        var self = this; 
        
        bus.$on('liveSearchCompleted', function(data){
            self.liveSearchCompleted(data);
        });
    },
    
    methods:{
        liveSearchCompleted:function(data){ 
            if(data && data.length > 0){
                jQuery('.hide-on-live-search').slideUp();
            }
        }
    },
    
    components:{
        
    }
});