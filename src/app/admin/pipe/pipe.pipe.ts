import { Pipe, PipeTransform } from '@angular/core';


@Pipe({
  name: 'pipe'
})

export class PipePipe implements PipeTransform {

  

  // transform(value: string): any {
  //   return value.replace(/<.*?>/g, ''); // replace tags
    
  // }

  transform(value: string) {
    var limit = 100
      value = value.replace(/<.*?>/g, ''); // replace tags
      limit = value.substr(0, limit).lastIndexOf(' ');
    
    return `${value.substr(0, limit)}${'...'}`;
   
  }

 

}
