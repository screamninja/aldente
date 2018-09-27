<?php echo 'ABOUT PAGE'; ?>

<ul>
    <li><a href="/">Main page</a><br></li>
    <li><a href="/api/about">API</a><br></li>
    <li><a href="../account/login">Login page</a><br></li>
    <li><a href="../account/register">Register page</a><br></li>
</ul>

<ul>
    <li><a href="/api/token">Get API Token</a><br></li>
</ul>

<div>
    <p>API Request Example</p>
    <pre>
{"jsonrpc": "2.0", "method": "getJson", "params": {"count": 2}, "id": 1}
    </pre>
    <p>API Response Example</p>
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
</div>