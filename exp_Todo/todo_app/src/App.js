import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './App.css';

const App = () => {
  const [todos, setTodos] = useState([]);
  const [newTodo, setNewTodo] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    axios.get('http://localhost:5000/todos')
      .then(response => setTodos(response.data))
      .catch(error => {
        console.error('Error fetching data:', error);
        setError('Failed to load todos.');
      });
  }, []);

  const handleAddTodo = () => {
    if (newTodo.trim() === '') {
      setError('Todo cannot be empty');
      return;
    }
    const todo = { id: Date.now().toString(), text: newTodo };
    axios.post('http://localhost:5000/todos', todo)
      .then(response => {
        setTodos([...todos, response.data]);
        setNewTodo('');
        setError('');
      })
      .catch(error => {
        console.error('Error adding todo:', error);
        setError('Failed to add todo.');
      });
  };

  const handleDeleteTodo = (id) => {
    axios.delete(`http://localhost:5000/todos/${id}`)
      .then(() => {
        setTodos(todos.filter(todo => todo.id !== id));
        setError('');
      })
      .catch(error => {
        console.error('Error deleting todo:', error);
        setError('Failed to delete todo.');
      });
  };

  return (
    <div className="App">
      <h1>ToDo List</h1>
      {error && <div className="error">{error}</div>}
      <input
        type="text"
        value={newTodo}
        onChange={(e) => setNewTodo(e.target.value)}
        placeholder="Add a new todo"
      />
      <button onClick={handleAddTodo}>Add</button>
      <ul>
        {todos.map(todo => (
          <li key={todo.id}>
            {todo.text}
            <button onClick={() => handleDeleteTodo(todo.id)}>Delete</button>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default App;
