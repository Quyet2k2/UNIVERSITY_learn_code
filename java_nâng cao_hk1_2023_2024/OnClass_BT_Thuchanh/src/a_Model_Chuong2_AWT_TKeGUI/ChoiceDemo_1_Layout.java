package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.*;

public class ChoiceDemo_1_Layout extends Frame{

    Choice myChoice; // ~ combo box
    Label l;

    public ChoiceDemo_1_Layout() {
        super("Choice demo!");
        this.setLayout(new FlowLayout());
        
        myChoice = new Choice(); // Khởi tạo
        myChoice.setBounds(20, 30, 50, 60);
        myChoice.addItem("Red"); // Thêm item red
        myChoice.addItem("Blue"); // Thêm item blue
        myChoice.addItem("Green"); // Thêm item green
        this.add(myChoice); // Gắn vào frame
        
        l=new Label("Ban da chon mau: ...");
        this.add(l);
        
        // Phương thức bắt sự kiện click vào nút đóng frame
        this.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
   }

    public static void main(String[] args) {// Khai báo đối tượng demo
        ChoiceDemo_1_Layout myFrame = new ChoiceDemo_1_Layout();
        myFrame.setSize(300, 150); // Định kích cỡ frame
        myFrame.setVisible(true); // Hiển thị frame
    }
}
