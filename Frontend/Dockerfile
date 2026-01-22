FROM node:20

WORKDIR /app

# Instalar dependencias
COPY package*.json ./
RUN npm install

# Copiar código
COPY . .

# Exponer Vite
EXPOSE 5173

# Arrancar Vite
CMD ["npm", "run", "dev", "--", "--host"]
