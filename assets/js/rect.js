export class Rect {
    constructor(w, h) {
        this.h = h;
        this.w = w;
    }

    get area() {
        return this.calcArea();
    }

    calcArea() {
        return this.h * this.w;
    }
}