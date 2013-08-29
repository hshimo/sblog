# How to install


## Nginx

```
try_files $uri $uri/ /index.php;
```

## lighttpd

```
url.rewrite-if-not-file = ("(.*)" => "/index.php/$0")
```



