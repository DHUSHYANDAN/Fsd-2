const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const fs = require('fs');
const app = express();
const PORT = 5000;

app.use(cors());
app.use(bodyParser.json());

const dataFilePath = './todos.json';

// Helper function to read data from the JSON file
const readDataFromFile = () => {
    if (fs.existsSync(dataFilePath)) {
        const jsonData = fs.readFileSync(dataFilePath);
        return JSON.parse(jsonData);
    } else {
        return [];
    }
};

// Helper function to write data to the JSON file
const writeDataToFile = (data) => {
    fs.writeFileSync(dataFilePath, JSON.stringify(data, null, 2));
};

// Get all todos
app.get('/todos', (req, res) => {
    const todos = readDataFromFile();
    res.json(todos);
});

// Add a new todo
app.post('/todos', (req, res) => {
    const newTodo = req.body;
    const todos = readDataFromFile();
    todos.push(newTodo);
    writeDataToFile(todos);
    res.status(201).json(newTodo);
});

// Delete a todo
app.delete('/todos/:id', (req, res) => {
    const { id } = req.params;
    let todos = readDataFromFile();
    todos = todos.filter(todo => todo.id !== id);
    writeDataToFile(todos);
    res.status(204).send();
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});