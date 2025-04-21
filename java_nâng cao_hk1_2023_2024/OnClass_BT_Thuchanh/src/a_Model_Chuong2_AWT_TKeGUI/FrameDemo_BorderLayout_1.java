package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class FrameDemo_BorderLayout_1 {

    public static void main(String[] args) {
        Frame f = new Frame("Demo BorderLayout!");
        f.setSize(500, 300);
        f.setLayout(new BorderLayout());
        
        f.add("West", new Button("West")); // Gắn vào vùng west
        f.add("East", new Button("East")); // Gắn vào vùng east
        f.add("North", new Button("North")); // Gắn vào vùng north
        f.add("South", new Button("South")); // Gắn vào vùng south
        // Gắn vào vùng center
        Button ok=new Button("OK");
        Button cancel=new Button("Cancel");
        f.add("Center", ok); // Gắn ok vào vùng center cua frame
        f.add("Center",cancel);
        
//        Panel p=new Panel();
//        p.setLayout(new FlowLayout());
//        
//        //Tao va gan vao panel nut OK
//        Button ok=new Button("OK");
//        ok.setBackground(Color.GRAY);
//        p.add(ok);
//        //Tao va gan vao panel nut Cancel
//        Button cancel=new Button("Cancel");
//        cancel.setBackground(Color.GRAY);
//        p.add(cancel);
//        
//        // Gan panel vao vung center cua Frame       
//        f.add("Center", p);
        f.setVisible(true);//Hien thi Frame

        // Phương thức bắt sự kiện click vào nút đóng frame
        f.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }
}
