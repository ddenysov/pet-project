export default defineNuxtPlugin(({$emitter: any}) => {
    if (process.client) {

        console.log('PLUGIN INIT');
        const url = new URL('http://localhost:3010/.well-known/mercure');
        url.searchParams.append('topic', 'https://updates/user/{id}');

        const eventSource = new EventSource(url);
        const nuxtApp = useNuxtApp()
        const $event = nuxtApp.$event;

        console.log($event);

        eventSource.onmessage = e => {
            const update = JSON.parse(e.data);
            $event(update.entity, update)
            console.log('JSON.parse(e.data)')
            console.log(JSON.parse(e.data))
        };
    }
});
