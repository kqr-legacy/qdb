
Copypasta `database.php.example` men ersätt värdena med rätt värden.

Eftersom url:er är på formen `http://qdb/random/` eller `http://qdb/single/id` så
behövs det en och annan rewrite i httpd-confen. I apache görs det med `.htaccess`-filer
tror jag, i nginx är det i sitens conf.

I nginx är formatet:

    rewrite ^/search/(.+)/p([0-9+])/?$ /index.php?action=search&q=$1&p=$2 last;
    rewrite ^/search/(.+)/?$ /index.php?action=search&q=$1 last;
    rewrite ^/add/([a-z]+)/?$ /index.php?action=add&err=$1 last;
    rewrite ^/([a-z]+)/?$ /index.php?action=$1 last;
    rewrite ^/([a-z]+)/p([0-9]+)/?$ /index.php?action=$1&p=$2 last;
    rewrite ^/([a-z]+)/([0-9a-f]+)/?$ /index.php?action=$1&hash=$2 last;
    rewrite ^/([a-z]+)/([0-9a-f]+)/(.+)$ /index.php?action=$1&hash=$2&delete=$3 last;


