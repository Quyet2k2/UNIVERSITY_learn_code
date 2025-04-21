/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Chuong2_AWT_TKeGUI;

import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.GridBagConstraints;
import java.awt.GridBagLayout;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.JTextField;

/**
 *
 * @author quyet
 */
public class Bai_5_Caclulator extends JFrame {

    JTextField t1;
    JButton b_backSpc, b_C, b_CE, b_MC, b_MR, b_MS, b_M_, b_cong, b_tru, b_0, b_1, b_2, b_3, b_4, b_5, b_6, b_7, b_8, b_9, b_doi_dau, b_cham, b_phan_so, b_nhan, b_chia, b_phan_tram, b_sprt, b_bang;
    JButton[] buttons1, buttons2, buttons3;

    public Bai_5_Caclulator() {
        super("Calculator - Java Nâng cao");
        this.setLayout(new GridBagLayout());
        this.setSize(600, 300);
//        this.setDefaultCloseOperation(EXIT_ON_CLOSE);
        this.setLocationRelativeTo(null);

        GridBagConstraints gbc = new GridBagConstraints();
        gbc.gridx = 0;
        gbc.gridy = 0;

        t1 = new JTextField("0");
        t1.setPreferredSize(new Dimension(100, 50));
        t1.setBackground(Color.blue);
        t1.setForeground(Color.WHITE); // Đặt màu chữ thành trắng
        t1.setHorizontalAlignment(JTextField.LEFT); // Căn lề văn bản sang trái
        t1.setEditable(false);
        b_backSpc = new JButton("Backspc");
        b_C = new JButton("C");
        b_CE = new JButton("CE");
        b_MC = new JButton("MC");
        b_MR = new JButton("MR");
        b_MS = new JButton("MS");
        b_M_ = new JButton("M+");
        b_0 = new JButton("0");
        b_1 = new JButton("1");
        b_2 = new JButton("2");
        b_3 = new JButton("3");
        b_4 = new JButton("4");
        b_5 = new JButton("5");
        b_6 = new JButton("6");
        b_7 = new JButton("7");
        b_8 = new JButton("8");
        b_9 = new JButton("9");
        b_doi_dau = new JButton("+/-");
        b_cham = new JButton(".");
        b_cong = new JButton("+");
        b_tru = new JButton("-");
        b_nhan = new JButton("*");
        b_chia = new JButton("/");
        b_sprt = new JButton("sqrt");
        b_phan_tram = new JButton("%");
        b_phan_so = new JButton("1/X");
        b_bang = new JButton("=");

        buttons1 = new JButton[]{b_backSpc, b_C, b_CE};
        buttons2 = new JButton[]{b_MC, b_7, b_8, b_9, b_MR, b_4, b_5, b_6, b_MS, b_1, b_2, b_3, b_M_, b_0, b_doi_dau, b_cham};
        buttons3 = new JButton[]{b_chia, b_sprt, b_nhan, b_phan_tram, b_tru, b_phan_so, b_cong, b_bang};

        // Thêm các thuộc tính khác của JTextField nếu cần
        this.add(t1, gbc);

        JPanel jPanel = new JPanel();
        jPanel.setLayout(new FlowLayout((int) LEFT_ALIGNMENT));
        t1.setForeground(Color.WHITE); // Đặt màu chữ thành trắng
        for (JButton jButton : buttons1) {
            jPanel.add(jButton);
        }
        this.add(jPanel);

        this.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

    public static void main(String[] args) {
        Bai_5_Caclulator bai_5_Caclulator = new Bai_5_Caclulator();
        bai_5_Caclulator.setVisible(true);
    }

}
