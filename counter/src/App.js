
import './App.css';
import {React,useState} from 'react';

function App() {
  const [counter,setCounter]=useState(0);

  const increase=() =>{
    setCounter(counter+1)
  }
  const decrease=() =>{
    setCounter(counter-1)
  }
  const reset=()=>{
    setCounter(0)
  }
  return (
   <>

   <div className='button'>
    <p className="name" > Counter APP   </p>
   <div className="num" >{counter}</div>
    <button className='b1' onClick={increase}>increment</button>
   <button  className="b2" onClick={decrease}>decrement</button>
   <br/>

   <button className='b3' onClick={reset}>reset</button>
   </div>


   </>
  );
}

export default App;
