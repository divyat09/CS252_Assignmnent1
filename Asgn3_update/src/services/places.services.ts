import { Place } from '../model/place.model';
export class PlacesService{
    private places : Place[] = [];
    addplace(newplace: Place){
        this.places.push(newplace);
    }
    getplaces(){
        return this.places.slice();
    }
}