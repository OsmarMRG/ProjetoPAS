const express = require('express');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');
const cors = require('cors');
const fs = require('fs');

const app = express();
const PORT = 3000;
const JWT_SECRET = 'paxsecurity123';

app.use(express.json());
app.use(cors());

let users = [];

// Carregar utilizadores do ficheiro JSON se ele existir
if (fs.existsSync('users.json')) {
    try {
        users = JSON.parse(fs.readFileSync('users.json'));
    } catch (e) {
        users = [];
    }
}

// Rota de Registo
app.post('/api/register', async (req, res) => {
    const { email, password } = req.body;

    // CORREÇÃO: Adicionadas as barras || (Operador OU)
    if (!email || !password) {
        return res.status(400).json({ error: 'Email e password obrigatórios' });
    }

    if (users.find(u => u.email === email)) {
        return res.status(400).json({ error: 'Email já registado' });
    }

    const hashedPassword = await bcrypt.hash(password, 10);
    const newUser = { id: Date.now().toString(), email, password: hashedPassword };

    users.push(newUser);
    fs.writeFileSync('users.json', JSON.stringify(users, null, 2));

    res.json({ message: 'Conta criada!' });
});

// Rota de Login
app.post('/api/login', async (req, res) => {
    const { email, password } = req.body;
    const user = users.find(u => u.email === email);

    // CORREÇÃO: Adicionadas as barras || e parênteses
    if (!user || !(await bcrypt.compare(password, user.password))) {
        return res.status(401).json({ error: 'Credenciais inválidas' });
    }

    const token = jwt.sign({ userId: user.id }, JWT_SECRET, { expiresIn: '1h' });
    res.json({ token, user: { id: user.id, email: user.email } });
});

// CORREÇÃO: Adicionadas crases ` ` e parênteses no console.log
app.listen(PORT, () => {
    console.log(`Servidor PAX Security a correr em: http://localhost:${PORT}`);
});