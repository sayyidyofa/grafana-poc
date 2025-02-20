FROM node:23-alpine3.20
LABEL authors="sayyidyofa"

WORKDIR /app

COPY . .

RUN npm i

ENV NODE_ENV=production

EXPOSE 3000

CMD ["node", "server.js"]
