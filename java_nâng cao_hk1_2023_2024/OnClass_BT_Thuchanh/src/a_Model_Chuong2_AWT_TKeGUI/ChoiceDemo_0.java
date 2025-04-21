package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import javax.swing.JFrame;

public class ChoiceDemo_0 {//extends JFrame {
    public static void main(String[] args) {
        Frame f=new Frame("Frame chua Choice!");
        f.setSize(300, 150);
        
        //Them choice va add vao Frame
        Choice c=new Choice();
        c.addItem("Green");
        c.addItem("Red");
        c.addItem("Yellow");
        f.add(c);
        
        f.setVisible(true);
    }
}
