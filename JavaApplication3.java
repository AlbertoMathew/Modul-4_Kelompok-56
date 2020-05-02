package ;

import java.util.Scanner;
import java.util.Stack;

/**
*
* @author acer
*/
public class stuck {

    /**
    * @param args the command line arguments
    */
    public static void main(String[] args) {
        int pilihan;
        int data;
        Stack ganjil = new Stack();
        Stack genap = new Stack();
        //looping until false condition
        do{
            //Displaying Menu
            System.out.println("--- Stack Menu ---");
            System.out.println("1. PUSH Item");
            System.out.println("2. POP Item Ganjil");
            System.out.println("3. POP Item Genap");
            System.out.println("4. Lihat Daftar Data Ganjil");
            System.out.println("5. Lihat Daftar Data Genap");
            System.out.println("6. Lihat Data Teratas Ganjil");
            System.out.println("7. Lihat Data Teratas Genap");
            System.out.println("0. Keluar");
            Scanner input = new Scanner(System.in);
            System.out.print("Masukkan Pilihan : ");
            pilihan = input.nextInt();
            //condition for choice
            switch (pilihan) {
                case 1:
                    System.out.print("Data yang ditambahkan : ");
                    data = input.nextInt();
                    if ((data % 2) == 0) {
                        genap.push(data);
                    } else if ((data % 2) == 1) {
                        ganjil.push(data);
                    }   System.out.println("");
                    break;
                case 2:
                    ganjil.pop();
                    System.out.println("");
                    break;
                case 3:
                    genap.pop();
                    System.out.println("");
                    break;
                case 4:
                    System.out.print(ganjil + " ");
                    System.out.println("");
                    break;
                case 5:
                    System.out.print(genap + " ");
                    System.out.println("");
                    break;
                case 6:
                    System.out.println("Data teratas : " + ganjil.peek());
                    System.out.println("");
                    break;
                case 7:
                    System.out.println("Data teratas : " + genap.peek());
                    System.out.println("");
                    break;
                case 0:
                    System.exit(0);
                default:
                    System.out.println("Pilihan Tidak Ada!!");
                    break; //end of condition
            }
        } while(pilihan!=0);//end looping
    }
    
    public static int[] arrayIntPush(int item, int[] oldArray) {
        int len = oldArray.length;
        int[] newArray = new int[len+1];
        System.arraycopy(oldArray, 0, newArray, 0, len);
        newArray[len] = item;

        return newArray;
    }
}
