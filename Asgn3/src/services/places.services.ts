export class PlacesService{
    private places : {title : string}[] = [];
    addplace(newplace: {title:string}){
        this.places.push(newplace);
    }
    getplaces(){
        return this.places.slice();
    }
}