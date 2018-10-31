<main>
    <section>
        <h3>API Request Example</h3>
        <pre>
{"jsonrpc": "2.0", "method": "getJson", "params": {"count": 2}, "id": 1}
    </pre>
        <h3>API Response Example</h3>
        <pre>
{
    "jsonrpc": "2.0",
    "result": [
        {
            "id": 1,
            "title": "News One",
            "text": "News One Text",
            "author": null,
            "post_date": null
        },
        {
            "id": 2,
            "title": "News Two",
            "text": "News Two Text",
            "author": null,
            "post_date": null
        }
    ],
    "id": "1"
}
    </pre>
        <form action="/api/token" method="post">
            <button type="submit">Get API Token</button>
        </form>
    </section>
</main>