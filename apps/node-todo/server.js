const express = require('express');
const cors = require('cors');
const mysql = require('mysql2/promise');
const fs = require("fs");
const app = express();

app.use(cors());
app.use(express.json());

const pool = mysql.createPool({
  host: 'localhost',
  user: 'todouser',
  password: 'todopass',
  database: 'tododb'
});

app.get('/', (req, res) => {
  const html = fs.readFileSync('./public/index.html', {encoding: 'utf-8'})
  res.send(html)
})

// Get all todos
app.get('/api/todos', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM todos ORDER BY created_at DESC');
    res.json(rows);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Create todo
app.post('/api/todos', async (req, res) => {
  const { title, description } = req.body;
  try {
    const [result] = await pool.query(
      'INSERT INTO todos (title, description, completed) VALUES (?, ?, false)',
      [title, description]
    );
    res.status(201).json({ id: result.insertId, title, description, completed: false });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Update todo
app.put('/api/todos/:id', async (req, res) => {
  const { id } = req.params;
  const { completed } = req.body;
  try {
    await pool.query('UPDATE todos SET completed = ? WHERE id = ?', [completed, id]);
    res.json({ message: 'Updated successfully' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Delete todo
app.delete('/api/todos/:id', async (req, res) => {
  const { id } = req.params;
  try {
    await pool.query('DELETE FROM todos WHERE id = ?', [id]);
    res.json({ message: 'Deleted successfully' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
