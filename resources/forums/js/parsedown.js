let cache = {};
let loading = [];
let current = null;

export default (plainText, preview) => {

    if (cache.hasOwnProperty(plainText)) {
        return cache[plainText];
    }

    if (loading.includes(plainText)) {
        return;
    }

    loading.push(plainText);

    let uid = Math.random().toString(36).substr(2, 9);

    current = uid;

    axios.post(route('api.parsedown'), {
            markdown: plainText
        })
        .then(response => {
            if (current != uid) {
                return;
            }

            delete loading[plainText];

            if (response.status == 200) {
                cache[plainText] = response.data;
                preview.innerHTML = cache[plainText];
            } else {
                preview.innerHTML = 'Error';
                console.log(response);
            }
        });

    return "Carregando...";
}
