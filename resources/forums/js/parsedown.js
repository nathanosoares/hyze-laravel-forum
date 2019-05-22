let cache = {};
let loading = [];

export default (plainText, preview) => {

    if (cache.hasOwnProperty(plainText)) {
        return cache[plainText];
    }

    if (loading.includes(plainText)) {
        return;
    }

    loading.push(plainText);

    axios.post(route('api.parsedown'), {markdown: plainText})
        .then(response => {
            delete loading[plainText];

            if (response.statusText === 'OK') {
                cache[plainText] = response.data;
                preview.innerHTML = cache[plainText];
            } else {
                preview.innerHTML = 'Error';
                console.log(response);
            }
        });

    return "Carregando...";
}