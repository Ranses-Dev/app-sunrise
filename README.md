## Run containers 

```sh
docker compose up --build -d

# Install Puppeteer
docker exec -it laravel-app npm install puppeteer

# Install poppler-utils (for the pdftotext command)
docker exec -it laravel-app apk add --no-cache poppler-utils
```
