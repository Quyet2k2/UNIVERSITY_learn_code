
import java.awt.*;

public class test  {

   

    public static void main(String[] args) {
        // Tạo một đối tượng Frame
        Frame frame = new Frame("Ví dụ GridBagLayout");

        // Tạo một đối tượng Panel để chứa các thành phần
        Panel panel = new Panel();
        frame.add(panel);

        // Sử dụng GridBagLayout cho Panel
        GridBagLayout layout = new GridBagLayout();
        panel.setLayout(layout);

        // Tạo và đặt các nhãn phía trên
        Label label1 = new Label("Label 1");
        Label label2 = new Label("Label 2");
        Label label3 = new Label("Label 3");

        GridBagConstraints gbc = new GridBagConstraints();
        gbc.gridx = 0;
        gbc.gridy = 0;
        gbc.gridwidth = 1;
        gbc.fill = GridBagConstraints.CENTER;
        panel.add(label1, gbc);

        gbc.gridx = 1;
        panel.add(label2, gbc);

        gbc.gridx = 2;
        panel.add(label3, gbc);

        // Tạo và đặt các nút
        Button button1 = new Button("Button 1");
        Button button2 = new Button("Button 2");
        Button button3 = new Button("Button 3");

        gbc.gridx = 0;
        gbc.gridy = 1;
        gbc.gridwidth = 1;
        panel.add(button1, gbc);

        gbc.gridx = 1;
        panel.add(button2, gbc);

        gbc.gridx = 2;
        panel.add(button3, gbc);

        // Hiển thị Frame
        frame.setSize(400, 200);
        frame.setVisible(true);
    }
}
