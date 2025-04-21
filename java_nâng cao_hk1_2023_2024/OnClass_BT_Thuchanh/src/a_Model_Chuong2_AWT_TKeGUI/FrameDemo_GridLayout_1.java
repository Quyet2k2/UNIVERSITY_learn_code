package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class FrameDemo_GridLayout_1 {

    public static void main(String args[]) {
        //Khai bao va khoi tao Frame co tieu de
        Frame f = new Frame("Demo Grid layout!");
        f.setSize(300, 150);
        f.setLayout(new GridLayout(0, 2));// thiet lap cach trinh bay Frame
        //Them cac button vao layout
        for (int i = 0; i < 10; i++) {
            f.add(new Button("Button" + i));
        }
        f.setVisible(true); //Hien thi Frame
        
        // Phương thức bắt sự kiện click vào nút đóng frame
        f.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }
}
