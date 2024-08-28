package FileProcessing;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;

public class DataClean {

    public static void main(String[] args) {

        File artists = new File("FileProcessing/album_list.csv");
        processFile(artists);

        // File genres = new File("fileProcessing/genres_unprocessed.csv");
        // createGenreList(genres);

    }
    

    // Processes album_list file to remove unwanted characters.
    public static void processFile(File filename) {

        File cleaned = new File("FileProcessing/cleaned_data.csv");

        FileReader fr;
        BufferedReader br;

        try {

            // Create file readers and writers.
            fr = new FileReader(filename);
            br = new BufferedReader(fr);
            FileWriter fw = new FileWriter(cleaned);
            BufferedWriter bw = new BufferedWriter(fw);

            // check is file to be writen to exists. if not, create it.
            if (!cleaned.exists()) {
                cleaned.createNewFile();
            }

            // (read in first line (header and write it to the new file)
            String line = br.readLine();
            System.out.println(line);

            // do data processing.

            String[] banned = { ",", ";", "\\", "!", "\"", "£", "$", "%", "^", "*", "{", "}", "[", "]", "@",
                    "#", "~", "<", ">", "?", "+", "=", "|", "¬", "`", "Ê" };
            // Set up clean string ready to cleaned information to be appended.

            while (line != null) {
                String cleanString = "";

                // Before splitting the line, I needed to add double quotes to each field in
                // Excel. Please see - Escaping data word doc.
                String[] row = line.split(",");

                // Loop through row to pick up each word.
                for (int i = 0; i < row.length; i++) {
                    // Loop through banned
                    for (int j = 0; j < banned.length; j++) {
                        // If row[i] contains banned character, replace it with ""
                        if (row[i].contains(banned[j])) {
                            row[i] = row[i].replace(banned[j], "");
                        }

                    }
                    cleanString = cleanString + row[i] + ",";
                }

                cleanString = cleanString.substring(0, cleanString.length() - 1);
                // System.out.println(cleanString);
                bw.write(cleanString);
                bw.newLine();

                line = br.readLine();

            }

            br.close();
            bw.close();
            fr.close();
            fw.close();

            // remove the final char from the string as it will be a comma.

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    // Creates a new CSV file which contains a list of all genres and subgenres to
    // be inserted into the database.
    public static void createGenreList(File filename) {

        File allGenres = new File("FileProcessing/cleaned_genres.csv");

        FileReader fr;
        BufferedReader br;

        try {

            // Create file readers and writers.
            fr = new FileReader(filename);
            br = new BufferedReader(fr);
            FileWriter fw = new FileWriter(allGenres);
            BufferedWriter bw = new BufferedWriter(fw);

            // check is file to be writen to exists. if not, create it.
            if (!allGenres.exists()) {
                allGenres.createNewFile();
            }

            ArrayList<String> genres = new ArrayList<String>();

            // (read in first line (header and write it to the new file)
            String line = br.readLine();
            // do data processing.

            while (line != null) {

                // Before splitting the line, I needed to add double quotes to each field in
                // Excel. Please see - Escaping data word doc.
                String[] row = line.split(",");

                // Loop through row and add each word as a new line to genres array if it is not
                // already in it.
                for (int i = 0; i < row.length; i++) {
                    String genre = row[i].replace('"', ' ');
                    genre = genre.trim();

                    if (!genres.contains(genre)) {
                        genres.add(genre);
                    }

                }

                line = br.readLine();
            }

            File artists = new File("FileProcessing/artists.csv");
            genres = removeArtists(artists, genres);

            for (String item : genres) {
                line = item;
                bw.write(line);
                bw.newLine();
            }

            br.close();
            bw.close();
            fr.close();
            fw.close();

            // remove the final char from the string as it will be a comma.

        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

    }

    // Helper function to remove artists from genre list
    public static ArrayList<String> removeArtists(File file, ArrayList<String> list) {

        try {
            FileReader fr = new FileReader(file);
            BufferedReader br = new BufferedReader(fr);

            ArrayList<String> artists = new ArrayList<String>();

            String line = br.readLine();
            while (line != null) {

                line = line.trim();
                artists.add(line);
                line = br.readLine();
            }

            for (int i = 0; i < list.size(); i++) {
                if (artists.contains(list.get(i))) {
                    list.remove(list.get(i));
                }
            }

            br.close();

        } catch (IOException e) {

            e.printStackTrace();
        }

        return list;

    }

}
