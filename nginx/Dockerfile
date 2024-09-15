FROM nginx:alpine

# 複製自定義的 nginx 配置
COPY nginx/oddly /etc/nginx/conf.d/default.conf

# 設置 Nginx 的根目錄
WORKDIR /var/www/html

# 開放 80 端口
EXPOSE 80
