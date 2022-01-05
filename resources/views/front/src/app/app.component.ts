import {Component} from '@angular/core';
import axios from "axios";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss'],
})

export class AppComponent {
  title = 'front';
  public products: any[] = [];
  public name: string = '';
  public price: number | null = null;

  constructor() {
   this.getData()
  }

  getData() {
    axios.get('http://localhost:8000/api/product/list')
      .then(response => {
        this.products = response.data
      })
      .catch(error => {
        console.log(error)
      })
  }

  onCreate() {
    if (!this.name || !this.price) {
      return;
    }

    const product = {
      name: this.name,
      price: this.price
    }

    axios.post('http://localhost:8000/api/product/create', product)
      .then(response => {
        this.getData()
        this.closeNew()
      })
      .catch(error => {
        console.log(error)
      })
  }

  onEdit(id: number) {
    let product = {};
    this.products.forEach(item => {
      if (item.id == id) {
        product = item
      }
    })

    axios.put('http://localhost:8000/api/product/' + id, product)
      .then(response => {
        this.getData()
      })
      .catch(error => {
        console.log(error)
      })
  }

  onDelete(id: number) {
    axios.delete('http://localhost:8000/api/product/' + id)
      .then(response => {
        this.getData()
      })
      .catch(error => {
        console.log(error)
      })
  }

  openModal(id: number) {
    // @ts-ignore
    document.getElementById('modalOpen_' + id).style.display = 'block'
  }

  closeModal(id: number) {
    // @ts-ignore
    document.getElementById('modalOpen_' + id).style.display = 'none'
  }

  openNew() {
    // @ts-ignore
    document.getElementById('modalOpenNew').style.display = 'block'
  }

  closeNew() {
    // @ts-ignore
    document.getElementById('modalOpenNew').style.display = 'none'
  }
}
