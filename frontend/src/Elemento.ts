
export interface ElementoJsonInterface {
    id: number;
    titulo: number;
    img: string;
    abono: number;
    riego: number;
    transplante: number;
}

export default class Elemento {
    private readonly id: number;
    private readonly titulo: number;
    private readonly img: string;
    private readonly riego: number;
    private readonly transplante: number;
    private readonly abono: number;
    
    public static fromJSON(json: ElementoJsonInterface | string): Card {
        if (typeof json === 'string') {
            return JSON.parse(json, Elemento.reviver);
        }
        return new Elemento(json.id, json.titulo, json.img, json.riego, json.abono, json.transplante);
    }

    public static reviver(key: string, value: ElementoJsonInterface): Elemento | ElementoJsonInterface {
        return key === '' ? Elemento.fromJSON(value) : value;
    }

    public toJSON(): ElementoJsonInterface {
        return {
            id: this.getId(),
            titulo: this.getTitulo(),
            titulo: this.getTitulo(),
            titulo: this.getTitulo(),
            titulo: this.getTitulo(),
        };
    }

    constructor(rank: number, suit: Suit) {
        if (typeof(Suit[suit]) !== 'string') {
            throw new Error('Invalid Suit');
        }
        if (rank < this.MIN_RANK || rank > this.MAX_RANK) {
            throw new Error('Invalid Rank');
        }
        this.rank = rank;
        this.suit = suit;
    }

    public getRank(): number {
        return this.rank;
    }

    public getRankName(): string {
        if (this.rank === 1) { 
            return 'Ace'; 
        } else if (this.rank === 11) { 
            return 'Jack'; 
        } else if (this.rank === 12) { 
            return 'Queen'; 
        } else if (this.rank === 13) { 
            return 'King'; 
        } else { 
            return '' + this.rank; 
        }
    }

    public getFullName(): string {
        return this.getRankName() + this.getSuitName();
    }

    public getSuit(): Suit {
        return this.suit;
    }

    public getSuitName(): string {
        return Suit[this.suit];
    }

    public getScore(): Array<number> {
        if (this.rank === 1) {
            return [1, 11];
        }
        return this.rank < 10 ? [this.rank] : [10];
    }
}