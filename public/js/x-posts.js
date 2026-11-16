(() => {
    let widgetsPromise;
    function widgets() {
        if (window.twttr?.widgets?.createTweet) return Promise.resolve(window.twttr.widgets);
        if (widgetsPromise) return widgetsPromise;
        widgetsPromise = new Promise((resolve,reject) => {
            const timer = setTimeout(() => reject(new Error('X widgets unavailable')), 15000);
            const ready = () => {
                if (window.twttr?.widgets?.createTweet) {clearTimeout(timer);resolve(window.twttr.widgets);}
                else window.twttr?.ready?.(() => {
                    if (window.twttr?.widgets?.createTweet) {clearTimeout(timer);resolve(window.twttr.widgets);}
                });
            };
            let script = [...document.scripts].find(script => /^https:\/\/platform\.(?:twitter|x)\.com\/widgets\.js(?:[?#]|$)/.test(script.src));
            const existing = Boolean(script);
            if (!script) {script=document.createElement('script');script.src='https://platform.twitter.com/widgets.js';script.async=true;}
            script.addEventListener('load',ready,{once:true});
            script.addEventListener('error',()=>{clearTimeout(timer);reject(new Error('X widgets unavailable'));},{once:true});
            ready();
            if (!existing) document.head.append(script);
        });
        return widgetsPromise;
    }
    function init() {
        document.querySelectorAll('[data-x-posts]').forEach(root => {
            if (root.dataset.xpBound) return;
            root.dataset.xpBound='1';
            const items=[...root.querySelectorAll('[data-xp-id]')].map(item=>({item,visible:false,width:0,generation:0}));
            if (!items.length) return;
            function render(state) {
                const width=Math.min(550,Math.floor(state.item.getBoundingClientRect().width));
                if (!state.visible || width<250 || Math.abs(width-state.width)<2) return;
                state.width=width;
                const generation=++state.generation;
                const slot=state.item.querySelector('[data-xp-embed]'),fallback=state.item.querySelector('[data-xp-fallback]');
                slot.replaceChildren();slot.hidden=true;fallback.hidden=false;
                const host=document.createElement('div');slot.append(host);
                let timer;
                const timeout=new Promise((_,reject)=>{timer=setTimeout(()=>reject(new Error('Post unavailable')),20000);});
                widgets().then(api=>{
                    if (state.generation!==generation) return null;
                    slot.hidden=false;
                    return Promise.race([api.createTweet(state.item.dataset.xpId,host,{
                        theme:root.dataset.xpTheme,conversation:root.dataset.xpConversation,width,lang:'ja',dnt:true,
                    }),timeout]);
                }).then(element=>{
                    if (state.generation!==generation) return;
                    slot.hidden=!element;fallback.hidden=Boolean(element);
                }).catch(()=>{if(state.generation===generation){slot.hidden=true;fallback.hidden=false;}}).finally(()=>clearTimeout(timer));
                // Attach a rejection handler while waiting for the shared widget script.
                timeout.catch(()=>{});
            }
            let resizeTimer;
            function layout() {
                const width=root.getBoundingClientRect().width;
                const columns=Math.max(1,Math.min(Number(root.dataset.xpColumns)||2,Math.floor((width+16)/266)));
                root.style.setProperty('--xp-columns',columns);
                clearTimeout(resizeTimer);
                resizeTimer=setTimeout(()=>items.forEach(render),150);
            }
            layout();
            if (window.ResizeObserver) new ResizeObserver(layout).observe(root);
            else window.addEventListener('resize',layout);
            if (window.IntersectionObserver) {
                const observer=new IntersectionObserver(entries=>entries.forEach(entry=>{
                    if(entry.isIntersecting){const state=items.find(state=>state.item===entry.target);state.visible=true;render(state);observer.unobserve(entry.target);}
                }),{rootMargin:'300px'});
                items.forEach(state=>observer.observe(state.item));
            } else items.forEach(state=>{state.visible=true;render(state);});
        });
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);
    else init();
})();
